<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Group sheet genrate</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            page-break-inside: avoid;
        }

        th {
            text-align: center;
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div style="text-align:center;margin-top:10px">
        <span>Shri Shivaji Vidya Prasarak Sanstha's Bapusaheb Shivajirao Deore Polytechnic, Dhule</span><br>
        <span style="font-size:20px"><i>Department of Computer Engineering</i></span>
    </div>
    <div style="justify-content: space-between; margin-top:10px;">
    
                <div style="width:38%;display:inline-block">
                    <div style="margin-bottom:5px"><label><b>Group No: </b><span><?php echo $student['groupno']; ?></span></label></div>
                    <!-- <div style="margin-bottom:5px"><label><b>Semester: </b><span><?php echo $week['semester']; ?></span></label></div> -->
                    <!-- <div style="margin-bottom:5px"><label><b>End Date: </b><span><?php 
                        $dateString = $row['enddate'];
                        $timestamp = strtotime($dateString);

                        // Format the timestamp as "dd/mm/yyyy"
                        $formattedDate = date("d/m/Y", $timestamp);
                        
                        echo $formattedDate;
                    ?></span></label></div>
                </div> -->
            </div>
            <br>
    <?php
    $selectQuery = "SELECT * FROM timeline where semester=5 and year='2023' order by weeknumber asc";
    $Result = mysqli_query($con, $selectQuery);
    ?>
    <table>
        <tr>
            <th style="width:20px">Week Number</th>
            <th style="width:130px">Activity Planned</th>
            <th>Task</th>
            <th style="width:20px">Evaluation</th>
        </tr>
    </table>
    <?php
    while ($row = mysqli_fetch_assoc($Result)) {
        $tid = $row['id'];
        $selectTQuery = "SELECT * FROM taskdetails where timelineid=$tid and year=2023 and groupno=1";
        $TResult = mysqli_query($con, $selectTQuery);
        $count = 0;
        $countTask = 0;
        while ($Trow = mysqli_fetch_assoc($TResult)) {
            $TaskId = $Trow['id'];
            $selectTSQuery = "SELECT * FROM taskstatus where taskid=$TaskId and studentid=81";
            $TSResult = mysqli_query($con, $selectTSQuery);
            if (mysqli_num_rows($TSResult) > 0) {
                $countTask++;
            }
            $count++;
        }
        ?>
        <table>
            <tr>
                <td rowspan="<?php echo $countTask ?>" style="width:57px">
                    <?php echo $row['weeknumber'] ?>
                </td>
                <td rowspan="<?php echo $countTask ?>" style="width:130px">
                    <?php echo $row['activityplan'] ?>
                </td>

                <?php

                if ($countTask == 0) {
                    ?>
                    <td>No Task Assign</td>
                    <td style="width:75px">N/A</td>
                <?php
                } else {
                    mysqli_data_seek($TResult, 0);
                    while ($Trow = mysqli_fetch_assoc($TResult)) {
                        $TaskId = $Trow['id'];
                        $selectTSQuery = "SELECT * FROM taskstatus where taskid=$TaskId and studentid=81";
                        $TSResult = mysqli_query($con, $selectTSQuery);
                        if (mysqli_num_rows($TSResult) > 0) {
                            $TSrow = mysqli_fetch_assoc($TSResult);
                            ?>
                            <td>
                                <?php echo $Trow['name'] ?>
                            </td>
                            <td style="width:75px">
                                <?php echo $TSrow['evaluation'] ?>
                            </td>
                            <?php
                            break;
                        }
                    }
                }
                ?>
            </tr>
            <?php
            mysqli_data_seek($TResult, 1);
            while ($Trow = mysqli_fetch_assoc($TResult)) {
                $TaskId = $Trow['id'];
                $selectTSQuery = "SELECT * FROM taskstatus where taskid=$TaskId and studentid=81";
                $TSResult = mysqli_query($con, $selectTSQuery);
                if (mysqli_num_rows($TSResult) > 0) {
                    $TSrow = mysqli_fetch_assoc($TSResult);
                    ?>
                    <tr>
                        <td>
                            <?php echo $Trow['name'] ?>
                        </td>
                        <td style="width:75px">
                            <?php echo $TSrow['evaluation'] ?>
                        </td>
                    </tr>
                <?php
                }
            }
            ?>
        </table>
    <?php
    }
    ?>
</body>

</html>
