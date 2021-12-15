                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto d-print-none">
                    <div class="container-fluid px-4">
                        <div class="align-items-center justify-content-between small">
                            <div class="text-muted text-center">
                                <hr>
                                Copyright &copy; HRMS Church
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="asset/js/bs.js"></script>
        <script src="asset/js/side_nav.js"></script>
        <script src="asset/js/datatable.js" crossorigin="anonymous"></script>
        <script src="asset/js/dataTables.js"></script>
<?php
    //check swal
    if(isset($_SESSION['swal'])){
        $swal = $_SESSION['swal'];
        unset($_SESSION['swal']);
        rswal($swal);
    }
?>
    </body>
</html>
<?php
    $conn->close();
?>