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

                    <div class="text-center">
                        {{ $msg }}
                    </div>

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
                    <form action="{{ url('/add') }}" method="POST">
                        @csrf
                        <input type="hidden" id="title" name="title">
                        <input type="hidden" id="cover" name="cover">
                        <table style="margin: auto;">
                            <tr>
                                <td class="text-right p-1">ISBN</td>
                                <td class="text-left p-1">
                                    <input type="text" id="isbn" name="isbn" placeholder="例)978-4-949999-12-0" style="width: 12rem;" autocomplete="off" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right p-1">ページ数</td>
                                <td class="text-left p-1">
                                    <input type="number" min="1" max="2147483647" step="1" style="width: 12rem;" id="num_of_pages" name="num_of_pages" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center p-1">
                                    <input type="submit" name="addbtn" id="addbtn" value="登録" disabled>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <script>
                    $(function() {
                        $('#isbn').on('input', function() {
                            var json = $.getJSON('https://api.openbd.jp/v1/get?isbn=' + $('#isbn').val(), function(json) {
                                if (json[0] != null) {
                                    /*--- Create preview table ---*/
                                    const preview_table = $('<table><tbody>');
                                    preview_table.addClass('m-auto');
                                    preview_table.addClass('lead');

                                    const title_preview_row = $('<tr></tr>');
                                    const title_preview = $('<td></td>');
                                    title_preview.attr('id', 'title_preview');
                                    title_preview.attr('colspan', '2');
                                    title_preview.addClass('p-2');
                                    title_preview.css('background-color', '#dcdcdc');
                                    title_preview.appendTo(title_preview_row);
                                    title_preview_row.appendTo(preview_table);

                                    const book_info_row = $('<tr></tr>');                                    
                                    const cover_preview_col = $('<td></td>');
                                    cover_preview_col.addClass('p-2');
                                    cover_preview_col.css('width', '224px');                                    
                                    const cover_preview = $('<img>');
                                    cover_preview.attr('id', 'cover_preview');
                                    cover_preview.css('width', '200');
                                    cover_preview.css('border', '1px solid');
                                    cover_preview.appendTo(cover_preview_col);
                                    cover_preview_col.appendTo(book_info_row);

                                    const author_preview_col = $('<td></td>');
                                    author_preview_col.addClass('p-2');
                                    author_preview_col.css('vertical-align', 'middle');
                                    const author_preview = $('<p></p>');
                                    author_preview.attr('id', 'author_preview');
                                    author_preview.appendTo(author_preview_col);
                                    const publisher_preview = $('<p></p>');
                                    publisher_preview.attr('id', 'publisher_preview');
                                    publisher_preview.appendTo(author_preview_col);
                                    author_preview_col.appendTo(book_info_row);
                                    book_info_row.appendTo(preview_table);

                                    $('</tbody></table>').appendTo(preview_table);
                                    $('#preview').html(preview_table);
                                    /*-------*/

                                    /*--- Set value ---*/
                                    $('#title_preview').html(json[0]["summary"]["title"]);
                                    $('#title').val(json[0]["summary"]["title"]);
                                    const cover_url = (json[0]["summary"]["cover"].length == 0 ? './templates/noimage.png' : json[0]["summary"]["cover"]);
                                    $('#cover_preview').attr('src', cover_url);
                                    $('#cover').val(cover_url);
                                    $('#author_preview').html(json[0]["summary"]["author"]);
                                    $('#publisher_preview').html(json[0]["summary"]["publisher"]);
                                    /*------*/

                                    /*--- Activate submit button ---*/
                                    $('#addbtn').prop('disabled', false);
                                    /*------*/
                                } else {
                                    const msg = $('<p>');
                                    msg.addClass('lead');
                                    msg.addClass('text-center');
                                    msg.append("Book's information is missing");
                                    $('</p>').appendTo(msg);
                                    $('#preview').html(msg);

                                    /*--- Disable submit button ---*/
                                    $('#addbtn').prop('disabled', true);
                                    /*------*/
                                }
                            });
                        });
                    });
                    </script>

                    <div id="preview" class="mt-4 mb-4">
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
