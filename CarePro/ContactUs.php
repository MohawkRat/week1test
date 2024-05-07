<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarePro</title>
</head>
<body>
    <?php include_once('navbar.php')?>
    <html>
    
    <head>
        <meta name ="viewport" content="width+device-width, initial-scale=1.0"></meta>
        <title>Contact us Page</title>
        <link rel="stylesheet" href="ContactUs.css">
        
    </head>

    <body>

        <header style="margin-left: 47%">
            Email:
        </header>
        <div class="container">
            <form method="POST"action="#" enctype="multipart/form-data">
                <!--mailto: Monkey@Gmail.com-->
                <h3>Send us an email: </h3>
                <input type="text" id="name" placeholder="Your CarePro Username" required></input>
                <input type="email" id="email" placeholder="Your CarePro Email" required></input>
                <textarea id="message" rows="4" placeholder="How can the CarePro Support Team help you ?"></textarea>
                <button type="submit" value = "send" >Send Email</button>
            </form>
        </div>
        <br></br>
        <header style="margin-left: 45%">
            Phone Number:
        </header>
        <p>Our Phone Number is:  11111111111</p>
        <br></br>
        <header style="margin-left: 48%">
            Post:
        </header>
        <p>Our Post box address is: 191 Walsall Rd, Lichfield WS13 8AQ</p>
    </body>
</html>
</body>
</html>