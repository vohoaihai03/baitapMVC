<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- {{ __("You're logged in!") }} --}}

                    {{ $dataTable->table() }}
                    {{-- <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Create At</th>
                            <th scope="col">Update At</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th>{{ ++$loop->index }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->create_at }}</td>
                                <td>{{ $user->update_at }}</td>
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                      {{$users->links()}} --}}

                </div>
            </div>
        </div>
    </div>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
</x-app-layout>
