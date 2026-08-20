<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MessageTemplateController extends Controller
{
    public function __construct()
    {
        $this->vFolder = 'panel.';
        $this->subFolder = 'tanimlar.';
        $this->lastFolder = 'message-template.';
    }

    public function index()
    {
        session(['sidebar' => 50]); // Yeni sidebar ID'si

        // Verileri doğrudan al
        $messageTemplates = MessageTemplate::orderBy('created_at', 'desc')->get();
        
        return view($this->vFolder.$this->subFolder.$this->lastFolder.'index', compact('messageTemplates'));
    }

    public function create()
    {
        return view($this->vFolder.$this->subFolder.$this->lastFolder.'create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:message_templates,slug',
            'content' => 'required|string',
            'parameters' => 'nullable|string',
        ]);

        $parametersArray = null;
        if ($request->parameters) {
            $parametersArray = json_decode($request->parameters, true);
        }

        MessageTemplate::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'parameters' => $parametersArray,
        ]);

        return redirect()->route('message-template.index')->with('success', 'Mesaj şablonu başarıyla oluşturuldu.');
    }

    public function edit($id)
    {
        $item = MessageTemplate::find($id);
        return view($this->vFolder.$this->subFolder.$this->lastFolder.'edit', compact('item'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:message_templates,slug,' . $request->id,
            'content' => 'required|string',
            'parameters' => 'nullable|string',
        ]);

        $item = MessageTemplate::find($request->id);
        
        $parametersArray = null;
        if ($request->parameters) {
            $parametersArray = json_decode($request->parameters, true);
        }

        $item->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'parameters' => $parametersArray,
        ]);

        return redirect()->route('message-template.index')->with('success', 'Mesaj şablonu başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $messageTemplate = MessageTemplate::findOrFail($id);
        $messageTemplate->delete();
        
        return response()->json([
            'success' => true, 
            'message' => 'Mesaj şablonu başarıyla silindi.'
        ]);
    }
}
