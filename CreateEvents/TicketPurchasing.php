<!DOCTYPE html>
<html lang="en">
<head>
  <title>TicketPurchase/EventsAround</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="TicketPurchasing.css">

</head>
<body>
<br>
<form id="Form">

    <div style="text-align: center;"><input id="FormTop" type="text" ><p>Event name will come have</p></div>
<hr>
<div style="text-align:center;"><input id="FormTop" type="text" ><p>Details</p></div>

<hr>
    <br>

    <div class="row" >
        <div class="form-group">
            <div class="input-group" id="Name">
                                                <input id="Name" type="email" class="form-control"  placeholder="Full Name*">
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
           <div class="input-group">
                                               <input id="Email"type="password" class="form-control" placeholder="Email*">
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
            <div class="input-group">
                                                <input id="Address" type="email" class="form-control"  placeholder="Address*">
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
           <div class="input-group">
                                               <input id="City" type="password" class="form-control" placeholder="City*">
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
            <div class="input-group">
                <select id="Country" required >
                    <option>--Select Country--</option>
                    <option>Pakistan</option>
                    <option>India</option>
                </select>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
           <div class="input-group">
            <select id="HowToGetTickets" required >
                <option>How do you want to get your Tickets?*</option>
                <option>I will Pick them when I arrive at the Event</option>
                <option>Please Email them to my Address</option>
            </select>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
           <div class="input-group">
            My Products<b style="color:red;">*</b> <br>
            <label >Adult Ticket Rs-/500,Child Ticket Rs-/200</label>
            <br>
            <label id="Label"></label>  <!--  <input type="text"> Here come the price of ticket which Organizer entered -->
            <br>
          <label id="QuantityLabel">Adult Tickets Quantity </label> <select id="Select" required >
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>

        </select>  
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
           <div class="input-group">
           <!--   <input type="text"> Here come the price of ticket which Organizer entered -->
           
         <label id="QuantityLabel">Child Ticket Quantity </label> <select id="Select" required >
          <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
    
        </select>  
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
           <div class="input-group">
            <label id="Total"> <b >Total Rs-/1000 </b></label>  <!--   <input type="text" > Total will be show auto in this text box after calculation(style="border: none;")-->

            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
           <div class="input-group">
             <p>Payment Meathod details with(Account numbers)</p>
            <label>Select Payment Method <b style="color: red;">*</b></label>
            <br>
            <i>Bank Transfer </i><input type="checkbox">
            <br>
            <i>EasyPaisa </i><input type="checkbox">
            <br>
            <i>Jazz Cash </i><input type="checkbox">

            </div>
        </div>
      </div>

<button class="button" id="PurchaseTicketbtn" type="submit" ><span>Purchase Ticket</span> </button>

<br><br>
</form>


</body>
</html>