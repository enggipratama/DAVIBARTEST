$html='
<body>
<div id="page">
  <div id="logo">
    <a href="http://www.danifer.com/"><img src="./HTML Invoice Template_files/invoice_logo.jpg"></a>
  </div><!--end logo-->

  <div id="address">

    <p><strong>'.$company.'</strong><br>
    <a href="mailto:'.$dbobj->getAdminEmail().'">'.$dbobj->getAdminEmail().'</a>
    <br><br>
    Transaction # xxx<br>
    Created on 2008-10-09<br>
    </p>
  </div><!--end address-->

  <div id="content">
    <p>
      <strong>Customer Details</strong><br>
      Name: '.$dbobj->UserFullName().'<br>
      Email: '.$dbobj->UserEmail().'<br>
      Contact: '.$dbobj->UserContact().'<br>
      Payment Type: MasterCard    </p>
    <hr>

    <table>
      <tbody>
        <tr>
        <td><strong>Description</strong></td>
        <td><strong>Qty</strong></td>
        <td><strong>Unit Price</strong></td>
        <td><strong>Amount</strong></td>
        </tr>
      <tr class="odd">
        <td>Product 1</td>
        <td>1</td>
         <td>Rs 1495.00</td>
        <td>Rs 1495.00</td>

      </tr>
      <tr class="even">
        <td>Product 2</td>
        <td>1</td>
       <td>Rs 1495.00</td>
        <td>Rs 1495.00</td>
      </tr>
        <tr class="odd">
          <td>Product 3</td>
          <td>1</td>
         <td>Rs 1495.00</td>
        <td>Rs 1495.00</td>
        </tr>

        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><strong>Total</strong></td>
          <td><strong>Rs 24485.00</strong></td>
        </tr>

    </tbody></table>


    <hr>
    <p>
      Thank you for your order.<br>
      If you have any questions, please feel free to contact us at <a href="mailto:'.$dbobj->getAdminEmail().'">'.$dbobj->getAdminEmail().'</a>.
    </p>

    <hr>
    <p>
      </p><center><small>This communication is for the exclusive use of the addressee and may contain proprietary, confidential or privileged information. If you are not the intended recipient any use, copying, disclosure, dissemination or distribution is strictly prohibited.
      <br><br>
      © '.$dbobj->sitename.' All Rights Reserved
      </small></center>
    <p></p>
  </div><!--end content-->
</div>
</body>;