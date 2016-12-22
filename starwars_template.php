<?php
/**
 * Created by PhpStorm.
 * User: Angela Adams
 * Date: 12/22/2016
 */

include 'swapi.php';
include 'helpers.php';
include 'Paginator.php';

GLOBAL $starships_results;
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Star Wars</title>
    <style>
        h1 {
            text-align: center;
            padding: 30px 0;
            background-color: black;
            color: white;
            height: 100px;
            width: 100%;
            margin: auto;
            border: solid darkgray 1px;
        }
        .bg-image {
            height: 240px;
            width: 100%;
            /* for small devices */
            background-image: url(/img/header.jpg);
            /* lt ie8 */
            -ms-background-position-x: center;
            -ms-background-position-y: bottom;
            background-position: center center;
            /* scale bg image proportionately */
            background-size: cover;
            /* ie8 workaround - http://louisremi.github.io/background-size-polyfill/ */
            -ms-behavior: url(https://cdn.css-tricks.com/backgroundsize.min.htc);
            /* prevent scaling past src width (or not) */
            /* max-width: 1200px; */
        }
        nav {
            text-align: center;
        }
        section {
            float: left;
        }
        .avatar {
            height: 180px;
            width: 180px;
            float: right;
        }
        .modal-header {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="bg-image"></div>
            <h1>Starships</h1>
        </header>

        <div class="modal fade" id="shipModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal of Holding</h4>
                    </div>
                    <div class="modal-body">
                        <p>It's bigger on the inside! :)</p>
                        <p>If you're reading this, then someone broke my modal code! >:/</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <script>
            $('#shipModal').on('show.bs.modal', function(event) {
                // Button that triggered the modal
                var button = $(event.relatedTarget);
                // Get data-xxx attribute of the clicked element
                var name = button.data('name');
                var manuf = button.data('manuf');
                var shipclass = button.data('shipclass');
                var hyper = button.data('hyper');
                var cargo = button.data('cargo');
                var cost = button.data('cost');
                var maxspeed = button.data('maxspeed');
                var mglt = button.data('mglt');

                // Update the modal's content.
                var modal = $(this);
                modal.find('.modal-title').text(name);
                modal.find('.modal-body').html(
                    "<p><strong>Manufacturer:</strong> " + manuf + "</p>" +
                    "<p><strong>Starship Class:</strong> " + shipclass + "</p>" +
                    "<p><strong>Hyperdrive Rating:</strong> " + hyper + "</p>" +
                    "<p><strong>Cargo Capacity:</strong> " + cargo + "</p>" +
                    "<p><strong>Cost in Credits:</strong> " + cost + "</p>" +
                    "<p><strong>Max Atmosphering Speed:</strong> " + maxspeed + "</p>" +
                    "<p><strong>MGLT:</strong> " + mglt + "</p>"
                );
            });
        </script>

        <?php
        $totalRecords = count($starships_results);

        // Paginates the results for the navbar
        $paginator = new Paginator();
        $paginator->total = $totalRecords;
        $paginator->paginate();

        $paginator->pageNumbers();

        // Sets loop variables for displaying results, based on current page and items per page
        $last = $paginator->currentPage * $paginator->itemsPerPage;
        $first = $last - $paginator->itemsPerPage;

        // Display results
        for($i=$first; $i<$last;$i++) {
            ?><div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <section>
                                <h2><?php echo ucwords($starships_results[$i]['name']) ?></h2>
                                <p><strong>Length: </strong><?php echo number_format( str_replace(",", "", $starships_results[$i]['length']) ) ?></p>
                                <p><strong>Crew: </strong><?php echo number_format($starships_results[$i]['crew']) ?></p>
                                <p><strong>Passengers: </strong><?php echo number_format($starships_results[$i]['passengers']) ?></p>
                                <!-- Note: I opted to send the data through the button instead of connecting
                                    to the API again because I have never done it this way before
                                    and I wanted to learn it.  It works, so I left it.  If this is a problem,
                                    please let me know and I will change it to an API call and resubmit. -->
                                <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#shipModal"
                                        data-name="<?php echo ucwords($starships_results[$i]['name']) ?>"
                                        data-manuf="<?php echo $starships_results[$i]['manufacturer'] ?>"
                                        data-shipclass="<?php echo ucwords($starships_results[$i]['starship_class']) ?>"
                                        data-hyper="<?php echo $starships_results[$i]['hyperdrive_rating'] ?>"
                                        data-cargo="<?php echo number_format($starships_results[$i]['cargo_capacity']) ?>"
                                        data-cost="<?php
                                            if ($starships_results[$i]['cost_in_credits'] == 'unknown') {
                                                echo "Unknown";
                                            } else {
                                                echo number_format($starships_results[$i]['cost_in_credits']);
                                            } ?>"
                                        data-maxspeed="<?php echo $starships_results[$i]['max_atmosphering_speed'] ?>"
                                        data-mglt="<?php echo $starships_results[$i]['MGLT'] ?>"
                                >More Info &raquo;</button>
                            </section>
                            <img class="avatar" src="<?php echo getPic($starships_results[$i]['name']) ?>" alt="<?php echo $starships_results[$i]['name'] . ' pic' ?>">
                        </div>
                    </div>
                </div>
            </div><?php
        } ?>
    </div>
</body>
<!-- Please Note: I am aware that I should extract the CSS and other code
    to DRY this up, but I'm *literally* sick and tired (I've been under the weather
    for the past few days). I'm sorry to leave it like this, but if I get hired, I will be
    more than happy to clean this up more.  Thank you for considering me for this position! -->
</html>