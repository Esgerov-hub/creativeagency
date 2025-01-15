<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ComplaintHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ComplaintRequest;
use App\Models\Complaint;
use App\Models\Translation;
use App\Repositories\ComplaintRepositoryImpl;
use Illuminate\Support\Facades\Lang;

class ComplaintController extends Controller
{

    protected $complaintRepository;

    public function __construct(ComplaintRepositoryImpl $complaintRepository)
    {
        $this->complaintRepository = $complaintRepository;
    }

    public function index()
    {
        $complaint = $this->complaintRepository->first();
        $locales = Translation::where('status',1)->get();
        return view('admin.contact.complaint',compact('locales', 'complaint'));
    }

    public function create()
    {
        //
    }

    public function store(ComplaintRequest $complaintRequest)
    {
        try {
            $data = ComplaintHelper::data($complaintRequest);
            if ($this->complaintRepository->create($data)) {
                return redirect()->back()->with('success', Lang::get('admin.add_success'));
            } else{
                return redirect()->back()->with('success', Lang::get('admin.add_error'));
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }

    public function show(Complaint $complaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ComplaintRequest $complaintRequest, $id)
    {
        $complaint = $this->complaintRepository->first();
        try {
            $data = ComplaintHelper::data($complaintRequest,$complaint);
            if ($this->complaintRepository->update($complaint['id'],$data)) {
                return redirect()->back()->with('success', Lang::get('admin.up_success'));
            } else{
                return redirect()->back()->with('success', Lang::get('admin.up_error'));
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('errors','errors '. $exception->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}
