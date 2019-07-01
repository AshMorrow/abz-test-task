<form id="remove_confirmation_modal" class="modal fade" method="post">
    @csrf
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p class="modal-text"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-flat btn-danger">Delete</button>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script>
        var $modal = $('#remove_confirmation_modal');
        function showDeletePopup(url, name) {
            $modal.find('.modal-title').text('Delete');
            $modal.find('.modal-text').html('Are you sure you want to delete ' + '<strong>' + name + '</strong>');
            $modal.attr('action', url)
            $modal.modal('show');
        }

        $modal.on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $modal.attr('action'),
                data: $modal.serialize(),
                success: function () {
                    $modal.modal('hide');
                    $currentDataTable.ajax.reload(null, false)
                }
            });
        })
    </script>
@endpush