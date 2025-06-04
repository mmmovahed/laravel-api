<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\storeCollegeRequest;
use App\Http\Requests\api\v1\updateCollegeRequest;
use App\Traits\ApiResponses;

class CollegeController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $colleges = College::all();
        return $this->ok("Colleges listed successfully", $colleges);
    }

    public function show($id)
    {
        $college = College::find($id);
        if (!$college) {
            return $this->error("Not found.", 404);
        }

        return $this->ok("Found successfully.", $college);
    }

    public function store(StoreCollegeRequest $request)
    {
        $college = College::create($request->validated());
        return $this->ok("College created successfully", $college);
    }

    public function update(UpdateCollegeRequest $request, $id)
    {
        $college = College::find($id);
        if (!$college) {
            return $this->error("Not found.", 404);
        }

        $college->update($request->validated());
        return $this->ok("Updated successfully", $college);
    }

    public function destroy(Request $request, $id)
    {
        $college = College::find($id);
        if (!$college) {
            return $this->error("Not found.", 404);
        }

        $college->delete();
        return $this->ok("Deleted successfully.");
    }
}
