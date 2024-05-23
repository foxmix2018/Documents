<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Document;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;




class DocumentController extends Controller
{

    public function  __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            // إذا كان المستخدم مشرفًا، إرجاع جميع الوثائق
            $documents = Document::latest()->paginate(5);
        } else {
            // إذا كان المستخدم عاديًا، إرجاع الوثائق الخاصة به فقط
            $documents = Document::where('user_id', auth()->id())->latest()->paginate(5);
        }


        $categories = Categories::all();
        return view('documents.index', compact('documents'), compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        return view('documents.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name_Doc' => 'required',
            'categories_id'=>'required',
            'doc_pdf'=>'required|mimes:pdf,jpeg,jpg,png|max:2048',
        ]);


        $idUser = Auth::id();

        $file = $request->file('doc_pdf');
        $time = Carbon::now();
        $directory = date_format($time, 'Y') . '/'.date_format($time, 'm');
        $fileName = date_format($time,'h').rand(1,9).'_'.$file->getClientOriginalName();
        Storage::disk('public')->putFileAs($directory, $file, $fileName);
        $document = Document::create([
            'name_Doc'=>$request->name_Doc,
            'categories_id'=>$request->categories_id,
            'Status'=>'Pending',
            'doc_pdf'=>$directory.'/'.$fileName,
            'user_id'=>$idUser,

        ]);

        return redirect()->route('documents')
            ->with('success', 'Document created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $categories = Categories::all();
        $getUser = User::all();
        return view('documents.show', compact('document', 'categories', 'getUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $categories = Categories::all();
        return view('documents.edit', compact('document'), compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {

        $request->validate([
            'name_Doc' => 'required',
            'categories_id'=>'required',
            'doc_pdf'=>'mimes:pdf,jpeg,jpg,png|max:2048',
        ]);
        $idUser = Auth::id();

        $document->update([
            'name_Doc'=>$request->name_Doc,
            'categories_id'=>$request->categories_id,
            'user_id_update'=>$idUser
        ]);
        $document->save();

if($request->hasFile('doc_pdf')) {
    $file = $request->file('doc_pdf');
    $time = Carbon::now();
    $directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
    $fileName = date_format($time, 'h') . rand(1, 9) . '_' . $file->getClientOriginalName();
    Storage::disk('public')->putFileAs($directory, $file, $fileName);
    $document->update([
    'doc_pdf'=>$directory . '/' . $fileName,
    ]);
    $document->save();
}

        return redirect()->route('documents')
            ->with('success', 'Document Updated successfully.');

    }


    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('documents')
            ->with('success', 'Document Deleted successfully.');
    }

    public function softDelete($id)
    {
        $document = Document::find($id)->delete();

        return redirect()->route('documents')
            ->with('success', 'Document Deleted successfully.');
    }


    public function statusAppr(Document $document)
    {
        $idUser = Auth::id();
        $document->update([
            'Status'=>'Approved',
            'user_id_update'=>$idUser
        ]);
        $document->save();

        return redirect()->route('documents')
            ->with('success', 'Document Approved successfully.');
    }
    public function statusRej(Document $document)
    {
        $idUser = Auth::id();
        $document->update([
            'Status'=>'Rejected',
            'user_id_update'=>$idUser
        ]);
        $document->save();

        return redirect()->route('documents')
            ->with('success', 'Document Rejected successfully.');
    }

    public function download($docPDF)
    {
        $file = Document::find($docPDF);
        if (!$file) {
            abort(404);
        }

        $pathofFile = str_replace('storage', 'public\uploads', storage_path($file->doc_pdf));
        return response()->download($pathofFile);
    }



}
