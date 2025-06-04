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
        return $this->ok("لیست دانشکده‌ها با موفقیت دریافت شد.", $colleges);
    }

    public function show($id)
    {
        $college = College::find($id);
        if (!$college) {
            return $this->error("دانشکده یافت نشد.", 404);
        }

        return $this->ok("دانشکده با موفقیت دریافت شد.", $college);
    }

    public function store(StoreCollegeRequest $request)
    {
        $college = College::create($request->validated());
        return $this->ok("دانشکده با موفقیت ایجاد شد.", $college);
    }

    public function update(UpdateCollegeRequest $request, $id)
    {
        $college = College::find($id);
        if (!$college) {
            return $this->error("دانشکده یافت نشد.", 404);
        }

        $college->update($request->validated());
        return $this->ok("دانشکده با موفقیت به‌روزرسانی شد.", $college);
    }

    public function destroy(Request $request, $id)
    {
        $college = College::find($id);
        if (!$college) {
            return $this->error("دانشکده یافت نشد.", 404);
        }

        $college->delete();
        return $this->ok("دانشکده با موفقیت حذف شد.");
    }
}
