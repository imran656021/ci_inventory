<?php $this->load->view('header'); ?>


<div class="tableData">
    <h1>Image Gallery</h1>
    <div class="create-btn-div">
        <a href="javascript:void(0)" class="btn btn-success create-btn" id="createModel">Insert Image</a>
    </div>
    <!-- =====================Modal Part start here ================= -->
    <!-- =====================Modal Part start here ================= -->

    <div id="imagedModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="brandForm">
            <div class="modal-header">
                <span class="close" id="modalCloseBtn">&times;</span>
                <h2 id="formTitle">Add Model</h2>
            </div>
            <div class="modal-body">
                <div class="brand-form" id="form">
                    <!-- form html load from js  -->
                </div>

            </div>

        </div>
    </div>
    <!-- ============alert Modal============ -->



    <div id="alertModal" class="modal">
        <div class="modal-content" id="alertModalContent">
            <div class="modal-header">
                <span class="close" id="alertModalCloseBtn">&times;</span>
            </div>
            <div class="modal-body">

                <h4 id="successAlert"></h4>
            </div>

        </div>
    </div>

    <!-- =====================Modal Part end here ================= -->
    <!-- =====================Modal Part end here ================= -->
    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Model Name</th>
                <th>Brand name</th>
                <th>Entry Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="modelTable">
            <!-- //load tabel row from js -->
        </tbody>



    </table>
</div>
<script src="<?= base_url() . 'assets/js/jquery-3.6.0.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/modal.js' ?>"></script>
<script>
    //initial setup =====================
    $('#nameError').html('');

    //innitial setup end====================
    $('#modalCloseBtn').click(function(e) {
        e.preventDefault();
        $('#imagedModal').css('display', 'none');
    });
    $('#alertModalCloseBtn').click(function(e) {
        e.preventDefault();
        $('#alertModal').css('display', 'none');
    });
    //=========================show create model popup Modal===============
    $('#createModel').click(function(e) {
        e.preventDefault();
        $('#imagedModal').css('display', 'block');
        $('#formTitle').html('Add Image');

        var createImageForm = `
                            <form action='' method='post' id='insertImage' name='insertImage' enctype='multipart/form-data'>
                                <label for='imageTitle'>Image Title</label>
                                <input class='form-control' type='text' id='imageTitle' name='imageTitle' placeholder='Enter A Image Title'>
                                <label for='image'>Image</label>
                                <input class='form-control' type='file' id='image' name='image'>
                                <p id='nameError'></p>

                                <input class='btn btn-success' type='submit' id='submit' name='submit' value='Add Image'>
                            </form>
                `;
        $('#form').html(createImageForm);

    });

    $('body').on('submit', '#insertImage', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url() . 'ImageController/store' ?>',
            type: 'post',
            dataType: 'json',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response){
                console.log(response);
                
            }
        });
    })
</script>
</body>

</html>