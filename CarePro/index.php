<?php
  include_once('sql.php');
  $sql = new sql();
?>

<style>

th, td {
  padding: 35px;
}

table.center {
    border-width: 15px;
    border-spacing: 5px;
    border-style: outset;
    border-color: #000000;
    border-collapse: separate;
}

table.center td {
    border-width: 2px;
    padding: 5px;
    border-style: inset;
    border-color: #000000;
    background-color: #ffff;
}

table.center th {
    background-color: grey;
}


table.center {
  margin-left: auto;
  margin-right: auto;
}

header {
	background-color: #333;
	color: white;
	padding: 20px;
	text-align: center;
  font-size: 50px;
}

* {
  box-sizing: border-box;
}

a {
  text-decoration: none;
  color: #379937;
}

body {
  margin: 40px;
}

.dropdown {
  position: relative;
  font-size: 14px;
  color: #333;

  .dropdown-list {
    padding: 12px;
    background: #fff;
    position: absolute;
    top: 30px;
    left: 2px;
    right: 2px;
    box-shadow: 0 1px 2px 1px rgba(0, 0, 0, .15);
    transform-origin: 50% 0;
    transform: scale(1, 0);
    transition: transform .15s ease-in-out .15s;
    max-height: 66vh;
    overflow-y: scroll;
  }
  
  .dropdown-option {
    display: block;
    padding: 8px 12px;
    opacity: 0;
    transition: opacity .15s ease-in-out;
  }
  
  .dropdown-label {
    display: block;
    height: 30px;
    background: #fff;
    border: 1px solid #ccc;
    padding: 6px 12px;
    line-height: 1;
    cursor: pointer;
    
    &:before {
      content: '▼';
      float: right;
    }
  }
  
  &.on {
   .dropdown-list {
      transform: scale(1, 1);
      transition-delay: 0s;
      
      .dropdown-option {
        opacity: 1;
        transition-delay: .2s;
      }
    }
    
    .dropdown-label:before {
      content: '▲';
    }
  }
  
  [type="checkbox"] {
    position: relative;
    top: -1px;
    margin-right: 4px;
  }
}

</style>



<!doctype html>
<head>
    <title>CarePro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
</head>

<body>

    <?php
      include_once('navbar.php');
      if (isset($_COOKIE['sessionid'])) {
        $user = $sql->getCookie($_COOKIE['sessionid']);
        if ($user) {
          if (!$user['Staff']) {
          ?>
          <h1>Illnesses</h1>

  <div class="dropdown" data-control="checkbox-dropdown">
  <label class="dropdown-label">Select</label>

  <div class="dropdown-list">

      <label class="dropdown-option">
      <input type="checkbox" name="dropdown-group" value="Alzheimers" />
        Alzheimers
      </label>

      <label class="dropdown-option">
      <input type="checkbox" name="dropdown-group" value="Arthritis" />
        Arthritis
      </label>

      <label class="dropdown-option">
      <input type="checkbox" name="dropdown-group" value="Asperger" />
        Asperger
      </label>

      <label class="dropdown-option">
      <input type="checkbox" name="dropdown-group" value="Blind" />
        Blind
      </label>

      <label class="dropdown-option">
      <input type="checkbox" name="dropdown-group" value="Cancer" />
        Cancer 
      </label>   
      
      <label class="dropdown-option">
      <input type="checkbox" name="dropdown-group" value="Cerebral palsy" />
        Cerebral palsy 
      </label>

      <label class="dropdown-option">
      <input type="checkbox" name="dropdown-group" value="Dementia" />
        Dementia 
      </label> 

      <label class="dropdown-option">
      <input type="checkbox" name="dropdown-group" value="Diabetes type 2" />
        Diabetes type 2 
      </label>   

      <label class="dropdown-option">
      <input type="checkbox" name="dropdown-group" value="Down syndrome" />
        Down syndrome 
      </label>    
  </div>

  <script>
  (function($) {
  var CheckboxDropdown = function(el) {
      var _this = this;
      this.isOpen = false;
      this.areAllChecked = false;
      this.$el = $(el);
      this.$label = this.$el.find('.dropdown-label');
      this.$checkAll = this.$el.find('[data-toggle="check-all"]').first();
      this.$inputs = this.$el.find('[type="checkbox"]');

      this.onCheckBox();
      
      this.$label.on('click', function(e) {
      e.preventDefault();
      _this.toggleOpen();
      });
      
      this.$checkAll.on('click', function(e) {
      e.preventDefault();
      _this.onCheckAll();
      });
      
      this.$inputs.on('change', function(e) {
      _this.onCheckBox();
      });
  };

  CheckboxDropdown.prototype.onCheckBox = function() {
      this.updateStatus();
      this.$illnesses = {
        "Alzheimers" : 0,
        "Arthritis" : 0,
        "Asperger" : 0,
        "Blind" : 0,
        "Cancer" : 0,
        "Cerebral palsy" : 0,
        "Dementia" : 0,
        "Diabetes type 2" : 0,
        "Down syndrome" : 0,
      };
      for (i = 0; i < this.$el.find(':checked').length; i++) {
        if (Object.keys(this.$illnesses).indexOf(this.$el.find(':checked')[i].value) > -1) {
          this.$illnesses[this.$el.find(':checked')[i].value] = 1
        } 
      }
      $.post("https://mi-linux.wlv.ac.uk/~2214257/CarePro/api.php", this.$illnesses, function(data, status) {
        // console.log(data);
        // put items here to be placed in the browser
        data = JSON.parse(data);
        if (data[0] != undefined) { 
        const div = document.getElementById("items");
        while (div.firstChild) { 
          div.removeChild(div.firstChild);
        }
        
        for (let i = 0; i < data.length; i++) {
          let item = document.createElement('div')
          let itemName = document.createElement('a');
          let itemSymptoms = document.createElement('p');
          let itemDescription = document.createElement('p');
          itemName.innerHTML = data[i]['Illnesses_Name'];
          itemName.href = data[i]['Illnesses_Link'];
          itemSymptoms.innerHTML = data[i]['Illnesses_Symptoms'];
          itemDescription.innerHTML = data[i]['Illnesses_Description'];
          item.append(itemName);
          item.append(itemSymptoms);
          item.append(itemDescription);;
          div.append(item);
          div.append(document.createElement('br'));
        }
      }
    });
  };

  function getKeyByValue(object, value) {
        return Object.keys(object).find(key => object[key] === value);
  }

  CheckboxDropdown.prototype.updateStatus = function() {
      var checked = this.$el.find(':checked');
      this.areAllChecked = false;
      this.$checkAll.html('Check All');
      
      if(checked.length <= 0) {
      this.$label.html('Select Options');
      }
      else if(checked.length === 1) {
      this.$label.html(checked.parent('label').text());
      }
      else if(checked.length === this.$inputs.length) {
      this.$label.html('All Selected');
      this.areAllChecked = true;
      this.$checkAll.html('Uncheck All');
      }
      else {
      this.$label.html(checked.length + ' Selected');
      }
  };

  CheckboxDropdown.prototype.onCheckAll = function(checkAll) {
      if(!this.areAllChecked || checkAll) {
      this.areAllChecked = true;
      this.$checkAll.html('Uncheck All');
      this.$inputs.prop('checked', true);
      }
      else {
      this.areAllChecked = false;
      this.$checkAll.html('Check All');
      this.$inputs.prop('checked', false);
      }
      
      this.updateStatus();
  };

  CheckboxDropdown.prototype.toggleOpen = function(forceOpen) {
      var _this = this;
      
      if(!this.isOpen || forceOpen) {
      this.isOpen = true;
      this.$el.addClass('on');
      $(document).on('click', function(e) {
          if(!$(e.target).closest('[data-control]').length) {
          _this.toggleOpen();
          }
      });
      }
      else {
      this.isOpen = false;
      this.$el.removeClass('on');
      $(document).off('click');
      }
  };

  var checkboxesDropdowns = document.querySelectorAll('[data-control="checkbox-dropdown"]');
  for(var i = 0, length = checkboxesDropdowns.length; i < length; i++) {
      new CheckboxDropdown(checkboxesDropdowns[i]);
  }
  })(jQuery);

  </script>
    <div id="items">

    </div>
      <?php
        } else {

          echo '<Header> Staff Time Table !</Header>';

          echo '
          <br></br>
          <html>
            <table class= "center" style="background-color:#f5f5f5" >
              <tr>
                <th></th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednsday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
                <th>Sunday</th>
              </tr>
              <tr>
                <td>00:00</<td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>00:30</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>01:00</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>01:30</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>02:00</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>02:30</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td></<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>03:00</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>03:30</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>04:00</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>04:30</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>05:00</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>05:30</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>06:00</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>06:30</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>07:00</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>07:30</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>08:00</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>08:30</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>09:00</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>09:30</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>10:00</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>10:30</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>11:00</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td>Mason -> Dennis</<td>
                <td>Todd -> Darren</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>11:30</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>12:00</td>
                <td>Lucy -> Bert</<td>
                <td>Lucy -> Bert</<td>
                <td>Lucy -> Frank</<td>
                <td>Lucy -> Bert</<td>
                <td>Lucy -> Bert</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>12:30</td>
                <td>Lucy -> Bert</<td>
                <td>Lucy -> Bert</<td>
                <td>Lucy -> Frank</<td>
                <td>Lucy -> Bert</<td>
                <td>Lucy -> Bert</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>13:00</td>
                <td>Lucy -> Bert</<td>
                <td>Lucy -> Bert</<td>
                <td>Lucy -> Frank</<td>
                <td>Lucy -> Bert</<td>
                <td>Lucy -> Bert</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>13:30</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>14:00</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td></<td>
                <td>Mason -> Larry</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>14:30</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td></<td>
                <td>Mason -> Larry</<td>
                <td></<td>
                <td></<td>
              </tr>
              <tr>
                <td>15:00</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td></<td>
                <td>Mason -> Larry</<td>
                <td>Mason -> Terry</<td>
                <td></<td>
              </tr>
              <tr>
                <td>15:30</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td></<td>
                <td>Mason -> Larry</<td>
                <td>Mason -> Terry</<td>
                <td></<td>
              </tr>
              <tr>
                <td>16:00</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td></<td>
                <td>Mason -> Larry</<td>
                <td>Mason -> Terry</<td>
                <td></<td>
              </tr>
              <tr>
                <td>16:30</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td></<td>
                <td>Mason -> Larry</<td>
                <td>Mason -> Terry</<td>
                <td></<td>
              </tr>
              <tr>
                <td>17:00</td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Frank</<td>
                <td></<td>
                <td>Mason -> Larry</<td>
                <td>Mason -> Terry</<td>
                <td></<td>
              </tr>
              <tr>
                <td>17:30</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Larry</<td>
                <td>Mason -> Terry</<td>
                <td></<td>
              </tr>
              <tr>
                <td>18:00</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Terry</<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>18:30</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Terry</<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>19:00</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Terry</<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>19:30</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Terry</<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>20:00</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Terry</<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>20:30</td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Terry</<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>21:00</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Terry</<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>21:30</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Terry</<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>22:00</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Terry</<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>22:30</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>23:00</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Dorris</<td>
              </tr>
              <tr>
                <td>23:30</td>
                <td>Todd -> Joe</<td>
                <td></<td>
                <td></<td>
                <td>Mason -> Dennis</<td>
                <td></<td>
                <td></<td>
                <td>Lucy -> Dorris</<td>
              </tr>
            </table>
            <br></br>
            </html>';
        }
      }
      } else {
        echo "<p>If you have an account please <a href='login.php'>login</a></p>";
      }

    ?>

    
</body>
</html>
