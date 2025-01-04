<?php
namespace App\Helpers;
use App\Models\Translation;
use Illuminate\Support\Str;

class StructureHelper
{
    public static function data($request,$structure,$instituteCategoryId)
    {
        $locales = Translation::where('status',1)->get();
        $full_name= []; $title = []; $slug = []; $reception_days = [];
        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $full_name[$code] = $request->input("full_name.".$code, '');
            $title[$code] = $request->input("title.".$code, '');
            $reception_days[$code] = $request->input("reception_days.".$code, '');
            $slug[$code] = Str::slug(trim($request->input("title.".$code, '')));
        }

        if($request->hasFile('file')){
            $file = time().$request->file->extension();
            $request->file->move(public_path('uploads/institute/structure'), $file);
        }else{
            $file = !empty($structure->file)? $structure->file: NULL;
        }
        $data = [
            'category_id' => $instituteCategoryId,
            'position_id' => $request->position_id ?? null,
            'parent_position_id' => $request->parent_position_id ?? null,
            'full_name' => $full_name,
            'file' => $file,
            'title' => $title,
            'slug' => $slug,
            'reception_days' => $reception_days,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ];

        return $data;
    }
}
