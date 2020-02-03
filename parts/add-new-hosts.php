<!-- Modal -->
<div class="modal fade" id="add_new_hosts" tabindex="-1" role="dialog" aria-labelledby="add_new_hosts"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_hosts_label">Add New Host Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="new_hosts_status"
                                   name="new_hosts_status">
                            <label class="custom-control-label" for="new_hosts_status">Host Status</label>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="host_ip" class="col-form-label">Host IP Address</label>
                        <input type="text" class="form-control" data-inputmask="'alias': 'ip'" id="host_ip"
                               name="host_ip"
                               placeholder="Example : 41.71.128.81">
                    </div>

                    <div class="form-group">
                        <label for="domains" class="col-form-label">Domain's</label>
                        <input type="text" class="form-control" id="domains" name="domains"
                               placeholder="example.com,example2.com">
                        <small>Enter multiple domain with <code>,</code> separated</small>
                    </div>

                    <div class="form-group">
                        <label for="comments" class="col-form-label">Notes</label>
                        <input type="text" class="form-control" id="comments" name="comments"
                               placeholder="This is for local testing">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="addnewhost" class="btn btn-primary addnew-hosts-entry">Create Entry
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>