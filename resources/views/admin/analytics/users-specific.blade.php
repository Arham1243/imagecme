@extends('admin.analytics.layouts.main')
@section('chart_data')
    <div class="form-box">
        <div class="form-box__header">
            <div class="title">Users</div>
        </div>
        <div class="form-box__body">
            <div class="table-container universal-table">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.analytics.user-specific', $item->id) }}"
                                            class="link">{{ $item->full_name }}</a>
                                    </td>
                                    <td>{{ $item->role }}</td>

                                    <td>{{ $item->email }}</td>

                                    <td>
                                        <a href="{{ route('admin.analytics.user-specific', $item->id) }}" class="themeBtn"><i
                                                class='bx bxs-show'></i>View Analytics</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
