<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BulkActionController extends Controller
{
    public function handle(Request $request, $resource)
    {
        $action = $request->input('bulk_actions');
        $selectedIds = $request->input('bulk_select', []);
        if (empty($selectedIds)) {
            return Redirect::back()->with('notify_error', 'No items selected for the bulk action.');
        }
        switch ($resource) {
            case 'cases':
                $modelClass = DiagnosticCase::class;
                $column = 'id';
                $redirectRoute = 'user.cases.index';
                break;
            default:
                return Redirect::back()->with('notify_error', 'Resource not found.');
        }

        return $this->handleBulkActions($modelClass, $column, $action, $selectedIds, $redirectRoute);
    }

    protected function handleBulkActions($modelClass, $idColumn, $action, $selectedIds, $redirectRoute)
    {
        switch ($action) {
            case 'delete':
                $modelClass::whereIn($idColumn, $selectedIds)->each(function ($model) {
                    $model->delete();
                });
                break;
            case 'draft':
                $modelClass::whereIn($idColumn, $selectedIds)->update(['status' => 'draft']);
                break;
            case 'publish':
                $modelClass::whereIn($idColumn, $selectedIds)->update(['status' => 'publish']);
                break;
            case 'restore':
                $modelClass::withTrashed()->whereIn($idColumn, $selectedIds)->each(function ($model) {
                    $model->restore();
                });
                break;
            case 'active':
                $modelClass::whereIn($idColumn, $selectedIds)->update(['status' => 'active']);
                break;
            case 'inactive':
                $modelClass::whereIn($idColumn, $selectedIds)->update(['status' => 'inactive']);
                break;
            case 'permanent_delete':
                $modelClass::onlyTrashed()->whereIn($idColumn, $selectedIds)->each(function ($model) {
                    $model->forceDelete();
                });
                break;
            default:
                break;
        }

        return redirect()->route($redirectRoute)->with('notify_success', 'Bulk action performed successfully!');
    }
}