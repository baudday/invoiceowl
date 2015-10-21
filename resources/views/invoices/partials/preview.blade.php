<div class="modal fade" id="preview_modal" tabindex="-1" role="dialog" aria-labelledby="preview_modal_label">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Preview Invoice</h4>
      </div>
      <div class="modal-body">
        <div id="preview"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
  $('.view-btn').on('click', function(e) {
    var _this = this;
    var btn = $(e.target);
    var href = '/api/v1/invoices/' + btn.data('invoice');

    $('#preview').html('<object data="' + href + '" type="application/pdf" width="100%" height="' + $(window).height()*0.7 + '"></object>');
    $('#preview_modal').modal('show');
  });
});
</script>
