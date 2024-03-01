<!-- Modal -->
<div class="modal fade" id="delete_company" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-type-dialog" dir="<?php echo  $page_dir ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="m-auto modal-title h5 " id="staticBackdropLabel"><?php echo lang("DELETE COMPANY") ?></h5>
            </div>
            <div class="modal-body">
                <form action="?do=delete" method="POST" id="deleteCompanyForm">
                    <!-- type id -->
                    <input type="hidden" name="deleted-company-id" id="deleted-company-id">
                    <!-- start company name field -->
                    <div class="mb-sm-2 mb-md-3 row">
                        <?php echo lang('ARE YOU SURE FOR DELETTION OPERATION ?') ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary py-1 px-5 fs-12" form="deleteCompanyForm" onclick="form_validation(this.form, 'submit')"><?php echo lang("DELETE") ?></button>
                <button type="button" class="btn btn-outline-secondary py-1 px-3 fs-12" data-bs-dismiss="modal"><?php echo lang("CLOSE") ?></button>
            </div>
        </div>
    </div>
</div>