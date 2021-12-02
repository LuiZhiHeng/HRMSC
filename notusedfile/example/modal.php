<button type="button" name="Comment" class="btn btn-primary mb-1 form-control" data-bs-toggle="modal" data-bs-target="#fileModal" data-bs-id="<?= $claim[0] ?>" data-bs-comment="<?= $claim[7] ?>">
    Text
</button>

<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title" class="modal-title">Manage Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="claim.php" method="POST" onsubmit="return confirms('Comment')">
                    <label for="commentName">Comment:</label>
                    <input type="hidden" id="id" name="id" hidden>
                    <input type="text" id="data" class="form-control mb-2" name="commentName">
                    <input type="submit" id="bttn" class="btn btn-danger form-control" name="comment" value="Save Comment">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var exampleModal = document.getElementById('fileModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-bs-id');
        var data = button.getAttribute('data-bs-comment');
        var modalBodyInputId = exampleModal.querySelector('.modal-body form #id');
        var modalBodyInputData = exampleModal.querySelector('.modal-body form #data');

        modalBodyInputId.value = id;
        modalBodyInputData.value = data;
    });
</script>