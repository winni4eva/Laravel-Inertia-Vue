<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Managers\CompanyManager;

class RatingController extends Controller
{
    public function __invoke(Request $request, Company $company)
    {
        $rating = $request->get('rating');

        $manager = new CompanyManager($company);

        $manager->rateCompany($rating, $company);
        
        return redirect()->route('home')
            ->with('message', 'Rating successfully saved');
    }
}
