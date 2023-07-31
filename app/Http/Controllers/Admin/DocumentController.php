<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Document\StoreDocumentRequest;
use App\Http\Requests\Admin\Document\UpdateDocumentRequest;
use App\Models\Document;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::simplepaginate(5);
        return view('admin.pages.document.list', compact('documents'));
    }

    public function create()
    {
        return view('admin.pages.document.create');
    }

    public function store(StoreDocumentRequest $request)
    {
        $documentPath = $this->storeFile($request);

        Document::create([
            'name' => $request->name,
            'path' => $documentPath
        ]);

        session()->flash('success', "Вы успешно добавили новый документ");
        return redirect()->route('admin.document.list');
    }

    public function edit(Document $document)
    {
        $documents = Document::all();
        return view('admin.pages.document.edit', compact('document','documents'));
    }

    public function update(UpdateDocumentRequest $request)
    {
        $document = Document::find($request->id);
        $documentPath = $this->storeFile($request);

        if($documentPath) {
            $this->destroyFile($document->path);
            $document->path = $documentPath;
        }
        $document->name = $request->name;
        $document->save();

        session()->flash('success', "Вы успешно обновили документ");
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        try {
            $document = Document::find($request->id);
            $this->destroyFile($document->path);
            $document->delete();
            session()->flash('success', 'Документ успешно удален');

            return response()->json(['status' => true, 'message' => 'Документ успешно удален']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Ошибка при удалении документа']);
        }
    }



    public function storeFile($request)
    {
        if($request->hasFile('document')){
            $filenameWithExt = $request->file('document')->getClientOriginalName();
            $filename = str()->slug(pathinfo($filenameWithExt, PATHINFO_FILENAME));
            $extention = $request->file('document')->getClientOriginalExtension();
            $fileNameToStore = "documents/".$filename."_".time().".".$extention;
            $request->file('document')->storeAs($fileNameToStore);
        }
        $urlDocument = $fileNameToStore ?? null;

        return $urlDocument;
    }

    public function destroyFile($oldFile)
    {
        if(Storage::disk('public')->exists($oldFile)){
            Storage::delete($oldFile);
        }
    }
}
