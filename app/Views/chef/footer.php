    <!--Footer-->
    <footer class="fixed-bottom bg-light text-lg-start mt-3">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright: SRO Version 0.0.3
    </div>
    <!-- Copyright -->
    </footer>
    <!--Footer-->
    <!-- <script src="./js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <!-- <script type="text/javascript" src="<?//base_url();?>/assets/js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="<?//base_url();?>/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?//base_url();?>/assets/js/dataTables.bootstrap5.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script> -->
    
    <!-- <script type="text/javascript" src="<?//base_url();?>/assets/js/script.js"></script> -->
    <!-- <script src="./js/script.js"></script> 
    <script>
      var firstTabEl = document.querySelector('#myList a:last-child')
      var firstTab = new bootstrap.Tab(firstTabEl)

      firstTab.show()
    </script>-->
    <script>
    $(document).ready(function() {
      $('#example').DataTable({
        "scrollY":        "400px",
        "scrollCollapse": true,
        "paging":         false
      });
    } );
    </script>
    
  </body>
</html>