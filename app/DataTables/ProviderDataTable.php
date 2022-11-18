<?php

namespace App\DataTables;
use App\Traits\DataTableTrait;

use App\Models\User;
use App\Models\Provider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProviderDataTable extends DataTable
{
    use DataTableTrait;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('display_name', function($provider) {
               
                return $provider->user->first_name. " ".$provider->user->last_name;
            })
            ->editColumn('state', function($provider) {
               
                return $provider->states->name;
            })
            ->editColumn('status', function($provider) {
                $status = '<span>'. ucfirst($provider->status) .'</span>';
                return $status;
            })
            ->addColumn('action', function($provider){
                return view('provider.action',compact('provider'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Provider $model)
    {
        $model = $model->with('user');
        if($this->list_status != null){

            $model = $model->where('status',"pending");
        } else {
            $model = $model->where('status',"approved");
        }

        return $model->newQuery()->orderBy('id','DESC');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->searchable(false)
                ->title(__('messages.srno'))
                ->orderable(false),
            Column::make('display_name')
                ->title(__('messages.name')),
            Column::make('contact_number'),
            Column::make('city'),
            Column::make('state')->title(__('messages.state')),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Provider_' . date('YmdHis');
    }
}
