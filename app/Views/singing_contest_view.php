<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<script type="text/javascript"  language="javascript">

	$(document).ready(function() {
        get_current_contest();
        get_past_winner();
        get_best_contestant();
	});

	function show_current_contest(data, is_progress = false){

		$('#content_div').empty();
		$( ".content_div" ).append( '<div style="margin:10px;" id="user_data_content"><h3>Current Contest : </h3></div>' );

		var contest_judges = "";
		var rounds_completed = 0;
		var round_genre = "";
        var is_data_empty = true;
        var content_data = "";

        $.each(data, function (key, item) {
            if(key == "contestJudges"){

                item.forEach(function(judge) {
                    if (typeof judge['judge_type'] !== 'undefined')
                    {
                        is_data_empty = false;

                        if(contest_judges == "")
                            contest_judges += judge["judge_type"];
                        else
                            contest_judges += " , " + judge["judge_type"];
                    }
                });
            }
            else if(key == "roundsComplete")
            {
                rounds_completed = item;
                is_data_empty = false;
            }
            else if(key == "roundGenre")
            {
                if(item != null)
                {
                    round_genre = item;
                    is_data_empty = false;
                }
                else
                {
                    round_genre = "N/A";
                }
            }
            else if(key == "contestantList"){
                is_data_empty = false;

                $.each(item, function(title, value){

                    content_data += "<tr>";

                    if (typeof value['contestant_id'] == 'undefined')
                        content_data += "<td></td>";
                    else
                        content_data += "<td>" + value['contestant_id'] + "</td>";

                    content_data += "<td>" + round_genre + "</td>";

                    content_data += "<td>" + rounds_completed + "</td>";

                    if (typeof value['contest_score'] == 'undefined')
                        content_data += "<td></td>";
                    else
                        content_data += "<td>" + value['contest_score'] + "</td>";

                    if (typeof value['round_performance'] == 'undefined')
                        content_data += "<td>0</td>";
                    else
                        content_data += "<td>" + value['round_performance'] + "</td>";

                    if(is_progress){
                        if (typeof value['is_sick'] == 'undefined')
                            content_data += "<td>NO</td>";
                        else
                            content_data += "<td>" + value['is_sick'] + "</td>";

                        if (typeof value['round_judge_score'] == 'undefined')
                            content_data += "<td>0</td>";
                        else
                            content_data += "<td>" + value['round_judge_score'] + "</td>";
                    }

                    content_data += "</tr>";
                });

                var tableHeaders = "<table id='data_table'><tr>";
                tableHeaders += "<th>Contestant ID</th>";
                tableHeaders += "<th>Round Genre</th>";
                tableHeaders += "<th>Rounds Completed</th>";
                tableHeaders += "<th>Contestant Overall Score By Judges</th>";
                tableHeaders += "<th>Contestant Performance ( Latest )</th>";
                if(is_progress)
                {
                    tableHeaders += "<th>Sick during Round</th>";
                    tableHeaders += "<th>Judges Score in Round</th>";
                }

                content_data = tableHeaders + content_data + "</table>";
            }
        });


		if(is_data_empty)
        {
            $( ".content_div" ).append( '<div style="margin:10px;" id="user_data_content"><p>Contest Finished or No Active Contest right now !!!</p></div>' );
        }
	    else
        {
            $( ".content_div" ).append( '<div style="margin:10px;" id="user_data_content"><h4>Contest Judges : <i style="color: darkred">' + contest_judges + '<i></h4></div>' );
            // $( ".content_div" ).append( '<div style="margin:10px;" id="user_data_content"><h4>Rounds Completed : ' + rounds_completed + '</h4></div>' );

            if(content_data != "")
                $( ".content_div" ).append( '<div style="margin:10px;" id="user_data_content">'+content_data+'</div>' );
        }
	}

	function show_past_winners(data){

        $('#past_winners_div').empty();
        $( ".past_winners_div" ).append( '<div style="margin:10px;" id="user_data_content"><h3>Past 5 Contest Winners : </h3></div>' );

        var content_data = "";
        $.each(data, function(title, value){

            content_data += "<tr>";

            if (typeof value['contest_id'] == 'undefined')
                content_data += "<td></td>";
            else
                content_data += "<td>" + value['contest_id'] + "</td>";

            if (typeof value['contestant_id'] == 'undefined')
                content_data += "<td></td>";
            else
                content_data += "<td>" + value['contestant_id'] + "</td>";

            if (typeof value['contest_score'] == 'undefined')
                content_data += "<td></td>";
            else
                content_data += "<td>" + value['contest_score'] + "</td>";

            if (typeof value['date_created'] == 'undefined')
                content_data += "<td></td>";
            else
                content_data += "<td>" + value['date_created'] + "</td>";

            content_data += "</tr>";
        });

        if(content_data != ""){

            var tableHeaders = "<table id='data_table'><tr>";
            tableHeaders += "<th>Contest ID</th>";
            tableHeaders += "<th>Contestant ID</th>";
            tableHeaders += "<th>Contest Score</th>";
            tableHeaders += "<th>Creation Date</th>";
            content_data = tableHeaders + content_data + "</table>";

            $( ".past_winners_div" ).append( '<div style="margin:10px;" id="user_data_content">'+content_data+'</div>' );
        }
        else {
            $( ".past_winners_div" ).append( '<div style="margin:10px;" id="user_data_content"><p>No Record Exists !!!</p></div>' );
        }
	}

	function show_best_contest(data){

        $('#best_contestant_div').empty();
        $( ".best_contestant_div" ).append( '<div style="margin:10px;" id="user_data_content"><h3>All Time Winner w.r.t Score : </h3></div>' );

        var content_data = "";
        $.each(data, function(title, value){

            content_data += "<tr>";

            if (typeof value['contest_id'] == 'undefined')
                content_data += "<td></td>";
            else
                content_data += "<td>" + value['contest_id'] + "</td>";

            if (typeof value['contestant_id'] == 'undefined')
                content_data += "<td></td>";
            else
                content_data += "<td>" + value['contestant_id'] + "</td>";

            if (typeof value['contest_score'] == 'undefined')
                content_data += "<td></td>";
            else
                content_data += "<td>" + value['contest_score'] + "</td>";

            if (typeof value['date_created'] == 'undefined')
                content_data += "<td></td>";
            else
                content_data += "<td>" + value['date_created'] + "</td>";

            content_data += "</tr>";
        });

        if(content_data != ""){

            var tableHeaders = "<table id='data_table'><tr>";
            tableHeaders += "<th>Contest ID</th>";
            tableHeaders += "<th>Contestant ID</th>";
            tableHeaders += "<th>Contest Score</th>";
            tableHeaders += "<th>Creation Date</th>";
            content_data = tableHeaders + content_data + "</table>";

            $( ".best_contestant_div" ).append( '<div style="margin:10px;" id="user_data_content">'+content_data+'</div>' );
        }
        else {
            $( ".best_contestant_div" ).append( '<div style="margin:10px;" id="user_data_content"><p>No Record Exists !!!</p></div>' );
        }
	}

	function get_current_contest()
	{
		const url = "<?php echo base_url(); ?>" + "/public/GetCurrentContest";

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			cache: false,
			success: function(data) {
                show_current_contest(data);
			}
		});
	}

	function get_past_winner()
	{
        const url = "<?php echo base_url(); ?>" + "/public/ContestHistory/getPreviousContestWinners";

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			cache: false,
			success: function(data) {
				show_past_winners(data['DATA']);
			}
		});
	}

	function get_best_contestant()
	{
        const url = "<?php echo base_url(); ?>" + "/public/ContestHistory/getAllTimeWinner";

		$.ajax({
			type: "GET",
			url: url,
			dataType: 'json',
			cache: false,
			success: function(data) {
				show_best_contest(data['DATA']);
			}
		});
	}

	function create_contest()
	{
		$("#save_status").html("Creating Contest...");
		$("#save_status").css("display", "block");

        const url = "<?php echo base_url(); ?>" + "/public/contest";

		$.ajax({
			type: "GET",
			url: url,
			success: save_document_completed,
			dataType: 'json',
			cache: false
		});
	}

	function save_document_completed(data)
	{
        get_current_contest();

        $("#save_status").html(data["MESSAGE"]);
		$('#save_status').fadeOut(3000, function() {
			$("#save_status").html(data["MESSAGE"]);
		});
	}

	function progress_contest()
	{
		$("#save_status").html("Progressing !!!");
		$("#save_status").css("display", "block");

        const url = "<?php echo base_url(); ?>" + "/public/Progress";

		$.ajax({
			type: "GET",
			url: url,
			success: progress_contest_completed,
			dataType: 'json',
			cache: false
		});
	}

	function progress_contest_completed(data)
	{
        show_current_contest(data, true);
		get_past_winner();
        get_best_contestant();

		$("#save_status").html("Progressed Successfully !!!");
		$('#save_status').fadeOut(3000, function() {
		});
	}

</script>

<style>
#data_table
{
width: 80%;
}

#data_table th
{
font-size:0.8em;
text-align:left;
/*padding-top:5px;*/
/*padding-bottom:4px;*/
background-color:#cecece;
color:black;
}
#data_table td, #data_table th
{
font-size:0.8em;
border:1px solid #cecece;
/*padding:3px 7px 2px 7px;*/
text-align:center;
}

.button {
	background-color: #4CAF50;
	border: none;
	border-radius: 10px;
	color: white;
	padding: 7px 25px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 16px;
	margin: 4px 2px;
	cursor: pointer;
}

.save_status{
	position:fixed;
	top:0px;
	background:#FFFF66;
	z-index:100000;
	left: 50%;
	padding:3px;
	margin-left:-40px;
	border:2px solid yellow;
	border-radius:3px;
	display:none;
}

</style>


<!DOCTYPE html>
<html lang="en">
<body>

<div class="save_status" id="save_status">
	Saving...
</div>
<button type="button" class="button" onclick="create_contest();">Create Contest</button>
<button type="button" class="button" onclick="progress_contest();">Progress Contest</button>

<div id="content_div" class="content_div" style="display:block;"></div>
<div id="past_winners_div" class="past_winners_div" style="display:block;"></div>
<div id="best_contestant_div" class="best_contestant_div" style="display:block;"></div>
<!--	<div style="margin:10px;" id="user_data_content"></div>-->

</body>
</html>
