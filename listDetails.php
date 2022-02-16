<div class="container-fluid">

    <!-- Page Heading -->
    <div class="panel-heading">
        <h6 class="panel-title">Search By :</h6>
    </div>
    <form id="serachForm" name="serachForm">
        <div class="row bg-inp">
            <div class="col-md-3 col-10">
                <div class="form-group">
                    <label>Details</label>
                    <input type="text" id="value" name="value" value="" class=" form-control" placeholder="Enter Details ">
                </div>
            </div>

            <div class="col-md-2 col-10">
                <div class="form-group">
                    <label>Search By</label>
                    <select id="searchBy" name="searchBy" class="form-control" style="width: 100%;">
                        <option disabled selected>Choose Type</option>
                        <option value="customer_name">Customer Name</option>
                        <option value="product_name">Product Name</option>
                        <option value="product_price">Price</option>
                    </select>
                </div>
            </div>

            <div id="searchResult" class="col-md-1 col-2">
                <label style="visibility: hidden;">for space</label>
                <img src="/img/search-b.png" width="30">
            </div>
        </div>
    </form>

</div>

<div class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">List Of Item</div>
        <div class="card-body">
            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                <div class="dataTable-container">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Customer Name</th>
                                <th>Customer Mail</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Sale Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php


                            if (isset($_GET['value']) && isset($_GET['searchBy'])) {
                                $sql = "SELECT * from sales as us WHERE us." . $_GET['searchBy'] . " LIKE '%" . $_GET['value'] . "%'";
                            } else {
                                $sql = "SELECT * from sales as us";
                            }



                            $result = $con->query($sql);

                            // Fetch all
                            $DBData = $result->fetch_all(MYSQLI_ASSOC);
                            $sr = 0;
                            $total = 0;

                            foreach ($DBData as $key => $value) {
                                $total = $total + @$value['product_price'];
                            ?>
                                <tr>
                                    <td><?= ++$sr ?></td>
                                    <td><?= @$value['customer_name'] ?></td>
                                    <td><?= @$value['customer_mail'] ?></td>
                                    <td><?= @$value['product_name'] ?></td>
                                    <td><?= @$value['product_price'] ?></td>
                                    <td><?= $newDate = date("d-m-Y", strtotime(@$value['sale_date'])); ?></td>
                                </tr>
                            <?php } ?>



                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sr No.</th>
                                <th>Customer Name</th>
                                <th>Customer Mail</th>
                                <th>Product Name</th>
                                <th>Total = <?= $total ?></th>
                                <th>Sale Date</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

<script src="vendor/jquery/customJS/listDetails.js"></script>