<?php
    require_once('config.php');
    require_once('content/includes/header.php');

    // allow the user to change region but keep the summoner they're already searching for
    if(isset($_GET['summoner']) && $_GET['summoner'] != null){
        
        $summonerName = "&summoner=".$_GET['summoner'];
        
    } else {
        $summonerName = "";
    }
?>

<body>

    <!-- Header / navbar -->
    <div id="header">
        <div id="header_content">
            <a name="maincontent"></a>
            <a href="index.php" id="logo">Champion Mastery</a>
            
            <!-- Switch region - current region displayed by default -->
            <div class="dropdown">
              <button class="dropdown_btn"><?php echo strtoupper($chosen_region); ?></button>
              <div class="dropdown_content">
                <a href="summonerPage.php?region=euw<?php echo $summonerName; ?>"><abbr title="Europe West">EUW</abbr></a>
                  <a href="summonerPage.php?region=eune<?php echo $summonerName; ?>"><abbr title="Europe North East">EUNE</abbr></a>
                  <a href="summonerPage.php?region=na<?php echo $summonerName; ?>"><abbr title="North America">NA</abbr></a>
              </div>
            </div>
            
            </div>
    </div>
    
    <?php 
    
        // the php that will actually get all the data to be displayed on the page
        require_once('data/summonerPage.php');
    
    ?>
    
    <script>
        // script to paginate the champions list
        
        jQuery(function($) {
            var target = $(".championRow");

            // How many parts do we have?
            var numPages = target.length;
            // 8 champions per page
            var perPage = 8;

            // Hide everything except page 1 by default
            target.slice(perPage).hide();
            
            // The actual numbers will go in div #pagination
            $(".pagination").pagination({
                items: numPages,
                itemsOnPage: perPage,
                cssStyle: "dark-theme",
                // The actual pagination
                onPageClick: function(pageNum) {
                    var start = perPage * (pageNum - 1);
                    var end = start + perPage;

                    // Hide everything, then show the selected page
                    target.hide()
                             .slice(start, end).show();
                }
            });
        }); 
    </script>
    
</body>