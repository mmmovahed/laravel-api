<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\SectionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\api\v1\storeSectionResourceRequest;
use App\Http\Requests\api\v1\updateSectionResourceRequest;
use App\Traits\ApiResponses;

class sectionResourceController extends Controller
{
    use ApiResponses;

    public function index($courseId)
    {
        $resources = SectionResource::where('course_id', $courseId)->get();
        return $this->ok('Resources fetched.', $resources);
    }

    public function store(storeSectionResourceRequest $request)
    {
        $filePath = $request->file('file')->store('resources', 'public');
        $thumbnailFilePath = $request->thumbnail_path('file')->store('thumbnails/sections', 'public');

        $resource = SectionResource::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $filePath,
            'thumbnail_path' => $thumbnailFilePath,
        ]);

        return $this->ok('Resource uploaded.', $resource);
    }

    public function update(updateSectionResourceRequest $request, SectionResource $resource)
    {
        if ($request->hasFile('file')) {
            \Storage::disk('public')->delete($resource->file_path);
            $resource->file_path = $request->file('file')->store('resources', 'public');
        }

        $resource->update($request->only(['title', 'type']));

        $resource->save();
        return $this->ok('Resource updated.', $resource);
    }

    public function destroy(SectionResource $resource)
    {
        if (Storage::disk('public')->exists($resource->file_path)) {
            Storage::disk('public')->delete($resource->file_path);
        }
        $resource->delete();

        return $this->ok('Resource deleted.');
    }

    public function show(SectionResource $resource)
    {
        return $this->ok('Resource fetched.', $resource);
    }

    public function download(Request $request, SectionResource $resource)
    {
        $user = $request->user();

        // چک کن کاربر در درس ثبت‌نام کرده یا نه
        $isRegistered = $resource->course->users()->where('user_id', $user->id)->exists();

        if (!$isRegistered && !$user->hasAnyRole(['admin', 'teacher'])) {
            return $this->error('You are not registered for this course.', 403);
        }

        if (!Storage::disk('public')->exists($resource->file_path)) {
            return $this->error('File not found.', 404);
        }

        return response()->download(
            storage_path('app/public/' . $resource->file_path),
            $resource->title . '.' . pathinfo($resource->file_path, PATHINFO_EXTENSION)
        );
    }

}
