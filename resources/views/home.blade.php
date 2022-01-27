@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">本棚</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <table class="table mt-3 mb-3">
                            @foreach($books as $book)
                            <?php
                                $percent = round(($book->reading_page / $book->full_page) * 100, 2);
                            ?>

                            <tbody>
                                <tr>
                                    <td style="height: 1em; background-color: #dcdcdc;" colspan="2">
                                        {{ $book->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 224px;">
                                        <img src="{{ $book->cover_url }}" border="1" style="width: 200;">
                                    </td>
                                    <td style="vertical-align: middle; text-align: center; width: 460px">
                                        <progress style="height: 1rem; width: 15rem;" value="{{ $book->reading_page }}" max="{{ $book->full_page }}"></progress>

                                        {{ $book->reading_page }} / {{ $book->full_page }} ({{ $percent }}%)
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
