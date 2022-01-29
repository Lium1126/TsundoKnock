$(function() {
	$('#testbtn').on('click', function() {
		// Clear on preview area
		$('#preview').empty();

		var json = $.getJSON('https://api.openbd.jp/v1/get?isbn=' + $('#isbn').val(), function(json) {
			if (json[0] != null) {
				/*--- Create preview table ---*/
				const preview_table = $('<table>');
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

				$('</table>').appendTo(preview_table);
				$('#preview').append(preview_table);
				/*-------*/

				/*--- Set value ---*/
				$('#title_preview').html(json[0]["summary"]["title"]);

				$('#cover_preview').attr('src', json[0]["summary"]["cover"]);
				$('#author_preview').html(json[0]["summary"]["author"]);
				$('#publisher_preview').html(json[0]["summary"]["publisher"]);
				/*------*/

				$('#addbtn').prop('disabled', false);
			} else {
				console.log('null');
				$('#addbtn').prop('disabled', true);
			}
		});
	});
});
