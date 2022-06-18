<?php $this->load->view('header'); ?>


<div class="tableData">
    <h1>Brand Lists</h1>
    <div class="create-btn-div">
        <a href="javascript:void(0)" class="btn btn-success create-btn" id="createBrand" onclick="showCreateModal()">Create Brand</a>
    </div>
    <table id="brandTable">
        <thead>
            <tr>
                <th>SL</th>
                <th>Brand name</th>
                <th>Entry Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="tbody">
            <!-- table row append from ajax request -->
        </tbody>



    </table>
    <div id="brandModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content" id="brandForm">
            <div class="modal-header">
                <span class="close" id="modalCloseBtn">&times;</span>
                <h2 id="formTitle">Add Brand</h2>
            </div>
            <div class="modal-body">
                <div class="brand-form" id="form">
                    <form action="" method="post" id="createForm" name="createForm">
                        <label for="name">Brand Name</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="Enter Brand Name">
                        <input type="hidden" id="id" name="id">
                        <p id="nameError"></p>

                        <input class='btn btn-success' type='button' onclick='creatBrand()' id='submit' name='submit' value='Add Brand'>
                    </form>
                </div>

            </div>

        </div>

        <!-- ============alert Modal============ -->


    </div>
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
</div>
<script src="<?= base_url() . 'assets/js/jquery-3.6.0.min.js' ?>"></script>
<script src="<?= base_url() . 'assets/js/modal.js' ?>"></script>

<script>
    //intial setup =========================
    $('#name').css('border', 'none').val('');
    $('#nameError').html('');


    // $('#alertModal').css('display', 'none');
    //========================show modal insert From ==================== 
    function showCreateModal() {
        $('#brandModal').css('display', 'block');
        $('#formTitle').html('Add Brand');
        $('#name').val('');
        var createFormData = `
                   <form action='' method='post' id='updateForm' name='updateForm'>
                        <label for='name'>Brand Name</label>
                        <input class='form-control' type='text' id='name' name='name' placeholder='Enter Brand Name'>
                        <p id='nameError'></p>
                        <input class='btn btn-success' type='button' onclick='creatBrand()' id='submit' name='submit' value='Add Brand'>
                        
                    </form>
                   `;

        $('#form').html(createFormData);
    }


    //=================modal close button=========
    $('#modalCloseBtn').click(function() {
        $('#brandModal').css('display', 'none');
    });
    $('#alertModalCloseBtn').click(function() {
        $('#alertModal').css('display', 'none');
    });



    function creatBrand() {
        var name = $('#name').val();
        $.ajax({

            url: '<?= base_url() . 'BrandController/store' ?>',
            type: 'post',
            dataType: 'json',
            data: {
                name: name
            },
            success: function(response) {
                if (response['status'] == 0) {
                    if (response['nameError'] != '') {
                        $('#name').css('border', '1px solid red');
                        $('#nameError').html(response['nameError']).css('color', 'red');
                    }
                } else {
                    $('#name').css('border', 'none');
                    $('#nameError').html('');

                    $('#brandModal').css('display', 'none');
                    $('#successAlert').html(response['db_res']).css('color', 'green');
                    $('#alertModal').css('display', 'block');
                    listView();


                }
            }
        });
    };

    function listView() {
        $.ajax({
            url: '<?= base_url() . 'BrandController/allData' ?>',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var tr = '';
                var allData = response['allData'];
                // console.log(allData.length);
                for (var i = 0; i < allData.length; i++) {
                    var sl = i + 1;
                    var id = allData[i]['id'];
                    var name = allData[i]['name'];
                    var entry_date = allData[i]['entry_date'];

                    tr = tr +
                        `<tr id='${id}'>
					  				<td>${sl}</td>
					  				<td>${name}</td>
					  				<td>${entry_date}</td>
					  				<td>
					  				<a onclick='editBrand(${id})' class='btn btn-success'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
					  				<a onclick='deleteBrand(${id})' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></a>

					  				</td>
					  	</tr>`;
                }
                //=============table data apppended===============
                $('#tbody').html(tr);
            }

        });
    }
    listView();

    //========================edite brand=======================
    function editBrand(id) {
        $.ajax({
            url: '<?= base_url() . 'BrandController/singleData/' ?>' + id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var data = response.row;
                if (data.name != '') {
                    $('#brandModal').css('display', 'block');
                    $('#formTitle').html('Update Brand');
                    var editeFormData = `
                   <form action='' method='post' id='updateForm' name='updateForm'>
                        <label for='name'>Brand Name</label>
                        <input class='form-control' type='text' id='name' name='name' placeholder='Enter Brand Name' value='${data.name}'>
                        <input type='hidden' id='id' name='id' value='${data.id}'>
                        <p id='nameError'></p>

                        <input class='btn btn-success' type='button' id='submit' onclick='updateBrand(${data.id})' value='Update Brand'>
                    </form>
                   `;

                    $('#form').html(editeFormData);
                    //value asign=====================
                    $('#name').val(data.name);
                    $('#id').val(data.id);

                }
            }
        })
    }
    //====================================update part goes there===================================
    //====================================update part goes there===================================


    function updateBrand(id) {

        // alert(id);
        var name = $('#name').val();
        var id = $('#id').val();
        $.ajax({
            url: '<?= base_url() . 'BrandController/updateBrand' ?>',
            type: 'post',
            dataType: 'json',
            data: {
                id: id,
                name: name
            },
            success: function(response) {
                if (response['status'] == 0) {
                    if (response['nameError'] != '') {
                        $('#name').css('border', '1px solid red');
                        $('#nameError').html(response['nameError']).css('color', 'red');
                    }
                } else {
                    $('#name').css('border', 'none');
                    $('#nameError').html('');

                    if (response['db_res'] == 'duplicate') {
                        // $('#brandModal').css('display', 'none');
                        $('#successAlert').html("Data Already Exist || Duplicate Data !!!").css('color', 'red');
                        $('#alertModal').css('display', 'block');
                        listView();

                    } else if (response['db_res'] == 'success') {
                         $('#brandModal').css('display', 'none');
                         $('#successAlert').html("Data Insert Successfully").css('color', 'green');
                        $('#alertModal').css('display', 'block');
                        listView();
                    } else {
                        // $('#brandModal').css('display', 'none');
                         $('#successAlert').html("Something went wrong").css('color', 'red');
                        $('#alertModal').css('display', 'block');
                    }

                }
            }

        });


    }

    //===========================delete Brand ========================
    function deleteBrand(id) {
        // alert(id);
        if (confirm("Are you sure want to delete data Permanently ????")) {
            $.ajax({
                url: '<?= base_url() . 'BrandController/deleteBrand/' ?>' + id,
                type: 'delete',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    if (response['deleteBrand'] != '') {
                        $('#successAlert').html(response['deleteBrand']).css('color', 'red');
                        $('#alertModal').css('display', 'block');
                        listView();
                    }
                }
            });
        }


    }
</script>

</body>

</html>