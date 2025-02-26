<a id="deleteModalId" style="display:none;" href="#" data-toggle="modal" data-target="#deleteModal">
    <i class="fa fa-plus-square fa-lg"></i> Delete Modal
</a>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
     aria-labelledby="deleteModal" aria-hidden="true">
</div>
<script>
    function deleteModal(id)
    {
        $('#deleteModal').html($('#m-'+id).html());
        $('#deleteModalId').click();
    }
</script>
<script src="{{ asset_url('bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset_url('bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset_url('bundles/jquery-ui/jquery-ui.min.js') }}"></script>