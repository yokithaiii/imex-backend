<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanyRequest;
use App\Http\Requests\Company\CompanyVerifyRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Models\Company\City;
use App\Models\Company\Company;
use App\Models\Company\CompanyVerify;
use App\Models\Company\Country;
use App\Models\Company\Region;
use App\Services\DaDataService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    protected $daDataService;

    public function __construct(DaDataService $daDataService)
    {
        $this->daDataService = $daDataService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $companies = Company::query()->paginate($perPage, ['*'], 'page', $page);

        return CompanyResource::collection($companies);
    }

    public function store(CompanyRequest $request)
    {
        $validatedData = $request->validated();

        if ($validatedData['type'] === 'jur') {
            $type = 'legal';
        } elseif ($validatedData['type'] === 'ip') {
            $type = 'individual';
        } else {
            $type = 'fiz';
        }

        $data = $this->daDataService->findCompanyByInn($validatedData['inn'], $type);
        if (!$data) {
            return response()->json(['error' => 'Компания не найдена.'], 404);
        }

        $existing = Company::query()
            ->where('inn', $data['data']['inn'])
            ->first();
        if ($existing) {
            return response()->json(['error' => 'Компания уже зарегистрирована.'], 409);
        }

        $country = Country::query()->updateOrCreate([
            'name' => $data['data']['address']['data']['country'],
            'iso_code' => $data['data']['address']['data']['country_iso_code'],
        ]);

        $region = Region::query()->updateOrCreate([
            'name' => $data['data']['address']['data']['region'],
            'region_fias_id' => $data['data']['address']['data']['region_fias_id'],
            'region_iso_code' => $data['data']['address']['data']['region_fias_id'],
            'region_type' => $data['data']['address']['data']['region_fias_id'],
            'country_id' => $country->id,
        ]);

        $city = City::query()->updateOrCreate([
            'name' => $data['data']['address']['data']['city'],
            'fias_id' => $data['data']['address']['data']['city_fias_id'],
            'region_id' => $region->id
        ]);

        $company = Company::query()->create([
            'user_id' => $request->user()->id,
            'type' => $validatedData['type'],
            'name_full' => $data['data']['name']['full_with_opf'],
            'name_short' => $data['data']['name']['short_with_opf'],
            'inn' => $data['data']['inn'],
            'kpp' => $validatedData['type'] == 'legal' ? $data['data']['kpp'] : null,
            'ogrn' => $data['data']['ogrn'],
            'okved' => $data['data']['okved'],
            'management_name' => $data['data']['management']['name'] ?? $data['data']['name']['full'],
            'management_post' => $data['data']['management']['post'] ?? 'ФИЗ.ЛИЦО',
            'address' => $data['data']['address']['value'],
            'postal_code' => $data['data']['address']['data']['postal_code'],
            'email_corporate' => $data['data']['emails'][0] ?? null,
            'phone_corporate' => $data['data']['phones'][0] ?? null,
            'is_verified' => false,
            'city_id' => $city->id
        ]);

        return response()->json([
            'message' => 'Company created success.',
            'data' => CompanyResource::make($company)
        ], 201);
    }

    public function show(Company $company)
    {
        return CompanyResource::make($company);
    }

    public function verify(CompanyVerifyRequest $request, Company $company)
    {
        $this->authorize('update', $company);

        $existing = CompanyVerify::query()
            ->where('company_id', $company->id)
            ->where('status', '=', 'pending')
            ->exists();
        if ($existing) {
            return response()->json(['error' => 'Заявка уже находится на проверке.'], 422);
        }

        $folder = 'verification_documents/' . $company->id;

        if ($request->hasFile('power_of_attorney')) {
            $attorneyPath = $request->file('power_of_attorney')->store($folder);
        }

        if ($request->hasFile('egrul')) {
            $egrulPath = $request->file('egrul')->store($folder);
        }

        if ($request->hasFile('passport')) {
            $passportPath = $request->file('passport')->store($folder);
        }

        CompanyVerify::query()->create([
            'company_id' => $company->id,
            'power_of_attorney' => $attorneyPath ?? null,
            'egrul' => $egrulPath ?? null,
            'passport' => $passportPath ?? null
        ]);

        return response()->json(['message' => 'Документы загружены. Ожидайте проверки.']);
    }

    public function delete(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();

        return response()->json(['error' => 'Вы успешно удалил Компанию'], 200);
    }
}
