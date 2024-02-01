<!-- Print Modal -->
<div class="modal fade" id="PrintKanbanModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title" id="PrintKanbanModalTitle">Print Kanban</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="PrintKanbanModalBody">
        <input type="hidden" id="kanban_printing_option">
        <input type="hidden" id="kanban_printing_query">
        <center>Select Printing Method</center>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue btn-block" data-dismiss="modal" onclick="print_kanban(1)">Normal Print (A4)</button>
        <button type="button" class="btn bg-lightblue btn-block" data-dismiss="modal" onclick="print_kanban(2)">Thermal Print</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->