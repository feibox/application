<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\FileUploadRequest;
use Krucas\Notification\Facades\Notification;
use Response;

class FileController extends Controller
{
    /**
     * @var File
     */
    private $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function download($file_id)
    {
        $file = $this->file->findOrFail($file_id);
        $file_path = storage_path('app/'.$file->filename);

        if (file_exists($file_path)) {
            return Response::download($file_path, $file->original_filename, [
                'Content-Length: '.filesize($file_path),
            ]);
        } else {
            Notification::error('Requested file does not exist on our server!');

            return redirect()->back();
        }
    }

    public function upload(FileUploadRequest $request, File $file)
    {
        $uploaded_file = $request->file('uploading_file');
        $path = $request->uploading_file->storeAs('files',
            $request->get('folder_id').str_random(32).md5($uploaded_file->getClientOriginalName()).'.'.$uploaded_file->getClientOriginalExtension());

        $file->create([
            'mime' => $uploaded_file->getClientOriginalExtension(),
            'filename' => $path,
            'original_filename' => $uploaded_file->getClientOriginalName(),
            'folder_id' => $request->get('folder_id'),
            'uploaded_by' => $request->user()->id,
        ]);

        Notification::success('File uploaded.');

        return redirect()->back();
    }

    public function destroy($file_id)
    {
        $file = $this->file->findOrFail($file_id);
        $file_path = storage_path('app/'.$file->filename);

        if (file_exists($file_path)) {
            unlink($file_path);
            $file->delete();
            Notification::info('File was deleted.');
        } else {
            Notification::error('Requested file does not exist on our server!');
        }

        return redirect()->back();
    }
}
