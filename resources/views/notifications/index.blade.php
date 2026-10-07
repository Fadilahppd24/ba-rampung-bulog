@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>
            <p class="text-sm font-semibold text-[#F28C28]">
                NOTIFIKASI
            </p>

            <h1 class="text-3xl font-bold text-[#123F7A]">
                Notifikasi
            </h1>
        </div>

        @if($notifications->where('is_read', false)->count() > 0)
            <form
                method="POST"
                action="{{ route('notifications.read-all') }}"
            >
                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="rounded-xl bg-[#123F7A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0d315f]"
                >
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif

    </div>


    <div class="space-y-3">

        @forelse($notifications as $notification)

            <div
                class="
                    rounded-2xl
                    border
                    p-5
                    {{ $notification->is_read
                        ? 'border-slate-200 bg-white'
                        : 'border-orange-200 bg-orange-50'
                    }}
                "
            >

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <h3 class="font-bold text-[#123F7A]">
                            {{ $notification->title }}
                        </h3>

                        <p class="mt-1 text-sm text-slate-600">
                            {{ $notification->message }}
                        </p>

                        <p class="mt-2 text-xs text-slate-400">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>

                    </div>

                    @if(!$notification->is_read)

                        <form
                            method="POST"
                            action="{{ route('notifications.read', $notification) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="text-xs font-semibold text-[#123F7A]"
                            >
                                Buka
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        @empty

            <div class="rounded-2xl bg-white p-10 text-center">
                <p class="text-slate-500">
                    Belum ada notifikasi.
                </p>
            </div>

        @endforelse

    </div>

    <div class="mt-5">
        {{ $notifications->links() }}
    </div>

</div>

@endsection