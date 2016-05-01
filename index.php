<?php
    
    require_once('config.php');
    require_once('content/includes/header.php');

    $searchBarPlaceholder = 'Summoner name ('.strtoupper($chosen_region).')';

?>

<body>
    
    <div id="home_container">
        <h1 id="homeTitle">Champion Mastery Lookup</h1>
        
        <!-- Home content goes in here -->
        <div id="home_content">
            
            <!-- dropdown to select region -->
            <div class="dropdown">
              <button class="dropdown_btn">Region</button>
              <div class="dropdown_content">
                <a href="index.php?region=euw"><abbr title="Europe West">EUW</abbr></a>
                  <a href="index.php?region=eune"><abbr title="Europe North East">EUNE</abbr></a>
                  <a href="index.php?region=na"><abbr title="North America">NA</abbr></a>
              </div>
            </div>
            
            <!-- search form -->
            <form action="summonerPage.php" method="get">
                <input type="search" id="searchBar" name="summoner" placeholder="<?php echo $searchBarPlaceholder ?>" maxlength="16">
                <input type="submit" id="searchButton" value="Search" >
            </form>
            
        </div>
    </div>
    
</body>