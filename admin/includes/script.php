  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/chart-area-demo.js"></script>
  <script src="../js/demo/chart-pie-demo.js"></script>
  <script src="../js/demo/chart-bar-demo.js"></script>

  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../js/demo/datatables-demo.js"></script>

  <script src="../js/moment.js"></script>

  <script>
    $('.comakers').dataTable({
        // "paging": false,
        //  "bInfo": false
    });
  </script>

  <script>
    $('.viewloantable').dataTable({
        // "paging": false,
        //  "bInfo": false
        "bSort": false
    });
  </script>

  <script>
  
    var table = document.getElementById('dataTable'), rIndex;

    for(var i = 0; i < table.rows.length; i++)
    {
      table.rows[i].onclick = function()
      {
        rIndex = this.rowIndex;
        document.getElementById('comaker').value = this.cells[1].innerHTML;
        document.getElementById('comakername').value = this.cells[1].innerHTML;
        document.getElementById('comakerid').value = this.cells[0].innerHTML;
      };
    }

  </script>

  <script>
    var monthTextBox = document.getElementById('months').value;
    $(document).ready(function()
    {
      $("#months").focusout(function()
      {
        var lt = $('#loantype').val();
        var g = '#'.concat(lt);
        var ranges = $(g).val();
        var array = new Array();
        var array = ranges.split(',');
        var rMonths = array[2];
        var d = $("#months").val();
        if(d < 0)
        {
          alert("Number of Months should not be less than 0");
          document.getElementById('months').value = ""; 
        }
        if(+d > +rMonths)
        {
          alert("Loan Type: " + lt + " Max Months: " + rMonths);
          document.getElementById('months').value = "";  
        }       

      });
    });
  </script>

  <script>
    var monthTextBox = document.getElementById('months').value;
    var loanT = document.getElementById('loantype');
    var loanType = loanT.options[loanT.selectedIndex].value;
    function validateMonth() 
    {
      var value = monthTextBox.value;
      if ($('#loantype').val() == 1) 
      {
        alert("Please select a loan type first");
        document.getElementById('months').value = "";
      }
    }
    // $('#loantype').change(function() 
    // {
    //   if( $(this).val() == 1) 
    //   {
    //     $('#months').prop( "disabled", true );    
    //   } 
    //   else 
    //   {       
    //     $('#months').prop( "disabled", false );
    //   }
    // });
  </script>

  <script>
    var amountTextBox = document.getElementById('amount1').value;
    var l = document.getElementById('loantype');
    var loanType = l.options[l.selectedIndex].value;
    function validateAmountRange() 
    {
      var value = amountTextBox.value;
      if ($('#loantype').val() == 1) 
      {
        alert("Please select a loan type first");
        document.getElementById('amount1').value = "";
      }
    }
  </script>

  <script>
    $(document).ready(function()
    {
      $("#dateStart").focusout(function()
      {
        var numOfMonths = $('#months').val();
        var startDate = $('#dateStart').val();
        var to = "";
        if(startDate == "" || startDate == null)
        {
          alert("Invalid Starting Date");   
        }
        else
        {

          startDate = new Date(startDate);
          var nm = numOfMonths;
          var n = parseInt(nm);
          var toD = moment(startDate).add(n, 'M');
          const endDate = moment(toD).format('DD/MM/YYYY');
          document.getElementById("dateEnd").value = endDate;
          document.getElementById("dateEndView").value = endDate;

        }
        
      });
    });
  </script>

  <script>
    
   $(document).ready(function()
    {

        var numOfMonths = $('#months').val();
        var startDate = $('#startDate').val();
        var to = "";
        
          startDate = new Date(startDate);
          var nm = numOfMonths;
          var n = parseInt(nm);
          var toD = moment(startDate).add(n, 'M');
          const endDate = moment(toD).format('DD/MM/YYYY');
          if (isNaN(endDate) == false) 
          {
          }
          else
          {
            document.getElementById("dateEndView").value = endDate;
          }
      
    });

  </script>

  <script>
    $(document).ready(function()
  {
    $("#amount1").focusout(function()
    {
      
        var lt = $('#loantype').val();
        var g = '#'.concat(lt);
        var ranges = $(g).val();
        var array = new Array();
        var array = ranges.split(',');
        var formatter = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'Php',
          minimumFractionDigits: 2,
          // the default value for minimumFractionDigits depends on the currency
          // and is usually already 2
        });
        var r1 = formatter.format(array[0]);
        var r2 = formatter.format(array[1]);

        var mainMoney = $(this).val();
        var fRange = array[0];
        var lRange = array[1];

        mainMoney = parseInt(mainMoney);

        fRange = parseInt(fRange);
        lRange = parseInt(lRange);


        if(mainMoney < fRange)
        {
          alert("Loan Type: " + lt + " Loan Range: " + r1 + "-" + r2);
          document.getElementById('amount1').value = ""; 
        }
        if(mainMoney > lRange)
        {
          alert("Loan Type: " + lt + " Loan Range: " + r1 + "-" + r2);
          document.getElementById('amount1').value = ""; 
        }
        // if(mainMoney < array[0] || mainMoney > array[1])
        // {
        //   alert("Loan Type: " + lt + " Loan Range: " + r1 + "-" + r2);
        // }
      // alert('hellow');
    });
  });
  </script>

  