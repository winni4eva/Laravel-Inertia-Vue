<?php


namespace App\Managers;


use App\Http\Resources\Company\CompanyResource;
use App\Models\Company;

class CompanyManager
{
    /**
     * Create with the context Company
     *
     * @var Company|null
     */
    private ?Company $company;

    public function __construct(Company $company = null)
    {
        $this->company = $company;
    }

    /**
     * Set the context Company
     *
     * @param Company $company
     */
    public function setCompany(Company $company):void
    {
        $this->company = $company;
    }

    /**
     * Get the context Company
     *
     * @return Company|null
     */
    public function getCompany():?Company
    {
        return $this->company;
    }

    /**
     * Get the context Company
     *
     * @param Company $company
     * @return CompanyResource
     */
    public function getCompanyResource(Company $company = null):CompanyResource
    {
        if($company) {
            $this->setCompany($company);
        }

        return new CompanyResource($this->company);
    }

    /**
     * Create a new Company and set as the context.
     *
     * @param array $data
     * @return mixed
     */
    public function createCompany(array $data)
    {
        return $this->company = Company::create($data);
    }

    /**
     * Update the context Company
     *
     * @param array $data
     * @param Company|null $company
     * @return Company
     */
    public function updateCompany(array $data, Company $company = null):Company
    {
        if($company) {
            $this->setCompany($company);
        }

        $this->company->update($data);
        $this->company->save();

        return $this->company;
    }

    /**
     * Delete the context company
     *
     * @param Company|null $company
     * @throws \Exception
     */
    public function deleteCompany(Company $company = null):void
    {
        if($company) {
            $this->setCompany($company);
        }

        $this->company->delete();

        $this->company = null;
    }

    public function rateCompany(int $rating, Company $company = null) :void
    {
        if($company) {
            $this->setCompany($company);
        }

        $company->ratings()->create([
            'user_id'   => auth()->user()->id,
            'rating'    => $rating
        ]); 
    }

}
