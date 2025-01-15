<?php
namespace App\Helpers;
use App\Models\Translation;

class ComplaintHelper
{
    public static function data($request,$complaint = null)
    {
        $locales = Translation::where('status',1)->get();
        $title = []; $text = []; $block_one = []; $block_two = []; $block_tree = []; $block_four = []; $file_title = [];
        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : 'az';
            $title[$code] = $request->input("title.".$code, '');
            $text[$code] = $request->input("text.".$code, '');
            $block_one[$code] = $request->input("block_one.".$code, '');
            $block_two[$code] = $request->input("block_two.".$code, '');
            $block_tree[$code] = $request->input("block_tree.".$code, '');
            $block_four[$code] = $request->input("block_four.".$code, '');
            $file_title[$code] = $request->input("file_title.".$code, '');
        }

        if($request->hasFile('file')){
            $files = time().$request->file->extension();
            $request->file->move(public_path('uploads/complaint'), $files);
        }else{
            $files = !empty($complaint->file)? $complaint->file: NULL;
        }

        $contact = [
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
        ];

        $block = [
            'block_one' => $block_one,
            'block_two' => $block_two,
            'block_tree' => $block_tree,
            'block_four' => $block_four,
        ];

        $file = empty($request->hasFile('file'))? $complaint['file']['file']: $files;
        $dataFile = ['file_title' => $file_title, 'file' => $file];
        $data = [
            'title' => $title,
            'text' => $text,
            'contact' => $contact,
            'block' => $block,
            'file' => $dataFile
        ];
        return $data;
    }
}
