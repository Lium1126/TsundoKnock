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
                                        <img src="{{ $book->cover_url }}" style="width: 200; border: 1px solid;">
                                    </td>
                                    <td class="align-middle text-center" style="width: 460px">
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


            <div class="card mt-3">
                <div class="card-header">書籍登録</div>

                <div class="card-body">
                    <form action="">
                        <table style="margin: auto;">
                            <tr>
                                <td class="text-right p-1">ISBN</td>
                                <td class="text-left p-1">
                                    <input type="text" id="isbn" name="isbn" placeholder="例)978-4-949999-12-0" style="width: 12rem;" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right p-1">ページ数</td>
                                <td class="text-left p-1">
                                    <input type="number" min="1" max="2147483647" step="1" style="width: 12rem;" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center p-1">
                                    <input type="submit" name="addbtn" id="addbtn" value="登録" disabled>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <button id="testbtn">テスト</button>
                    <script>
                    $(function() {
                        $('#testbtn').on('click', function() {
                            var preview_area = $('#preview');

                            var json = $.getJSON('https://api.openbd.jp/v1/get?isbn=' + $('#isbn').val(), function(json) {
                                if (json[0] != null) {
                                    // input hiddenへの登録も忘れずに
                                    $('#title_preview').html(json[0]["summary"]["title"]);
                                    $('#cover_preview').attr('src', json[0]["summary"]["cover"]);
                                    $('#author_preview').html(json[0]["summary"]["author"]);
                                    $('#publisher_preview').html(json[0]["summary"]["publisher"]);

                                    $('#addbtn').prop('disabled', false);
                                } else {
                                    console.log('null');
                                    $('#addbtn').prop('disabled', true);
                                }
                            });
                        });
                    });
                    </script>

                    <div id="preview" class="mt-4 mb-4">
                        <table class="m-auto lead">
                            <tr>
                                <td colspan="2" id="title_preview" style="height: 1rem; background-color: #dcdcdc;" class="p-2"></td>
                            </tr>
                            <tr>
                                <td style="width: 224px;" class="p-2">
                                    <img style="width: 200; border: 1px solid;" id="cover_preview">
                                </td>
                                <td style="vertical-align: middle;" class="p-2">
                                    <p id="author_preview"></p>
                                    <p id="publisher_preview"></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
