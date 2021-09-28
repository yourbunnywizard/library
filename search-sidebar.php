<?php 
	require('app/models/connection.php');

	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

	$query ="SELECT id_genre, name FROM genre order by id_genre";

 ?>

	<h2 class="sidebarName">Поиск</h2>

	<div class="sidebar-genres">
		<span class="categTitle">Жанры:</span>

<?php 

$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	
if($result)
{
	echo '<ul class="sidebar-genres-list" id="sidebar-genres-list">';

    $rows = mysqli_num_rows($result);
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);
?>

	<li><input type="checkbox" id="genre-<?php echo $row[0];?>"><label for="genre-<?php echo $row[0];?>"><?php echo $row[1];?></label></li>

<?php  

    }
    mysqli_free_result($result);
    echo '</ul>';
}	

?>		

	</div>



	<div class="sidebar-pageCount">
		<span class="categTitle">К-во страниц:</span>
	
		<div class="multi-range-slider">

			<span class="sliderValue pageCount-minValue" id="pageCount-minValue">0</span>
			<div class="slider pageCount">

<?php 
	$query = "SELECT Max(page_count), Min(Year(date_publishing)) from book";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	if(!$result) echo 'Error';
	
	$row = mysqli_fetch_row($result);
?>	
				<input type="range" id="pc_input-left" min="0" max="<?php echo $row[0]; ?>" value="150">
				<input type="range" id="pc_input-right" min="0" max="<?php echo $row[0]; ?>" value="<?php echo $row[0]; ?>">		
				<div class="track"></div>
				<div class="range"></div>
				<div class="thumb left"></div>
				<div class="thumb right"></div>
			</div>
			<span class="sliderValue pageCount-maxValue" id="pageCount-maxValue">100</span>
			
		</div>

	</div>


	<div class="sidebar-publicYear">
		<span class="categTitle">Годы написания:</span>

		<div class="multi-range-slider">
			
			<span class="sliderValue publicYear-minValue" id="publicYear-minValue">0</span>
			<div class="slider publicYear">		
				<input type="range" id="py_input-left" min="<?php echo $row[1]; ?>" max="2020" value="<?php echo $row[1]; ?>">
				<input type="range" id="py_input-right" min="<?php echo $row[1]; ?>" max="2020" value="2020">		
				<div class="track"></div>
				<div class="range"></div>
				<div class="thumb left"></div>
				<div class="thumb right"></div>
			</div>
			<span class="sliderValue publicYear-maxValue" id="publicYear-maxValue">100</span>
			
		</div>
	</div>

<?php 

mysqli_free_result($result);

?>

<?php 

mysqli_close($link);

 ?>



	<button class="searchBtn" id="searchBtn">Найти</button>
	<script>


		$('#searchBtn').click(function() {

			var genreArr = [];
			var pageLim = [$('span#pageCount-minValue').text(), $('span#pageCount-maxValue').text()];
			var yearLim = [$('span#publicYear-minValue').text(), $('span#publicYear-maxValue').text()];

			var $list = $('ul#sidebar-genres-list > li');

			var k = 0;
			for (var i = 0; i < $list.length; i++) {
				if ($list.eq(i).find('input[type=checkbox]').is(':checked')) {genreArr[k] = i + 1; k++;}
				
			}

			var sendData = {
				'genreArr' : genreArr,
				'pageLim' : pageLim,
				'yearLim' : yearLim
			}

			$.ajax({
				type: 'POST',
				url: 'app/models/easyQueryHendler.php',
				data: sendData,
				success: function(data) {
					$('#template').html(data);
				}
			});

		});


		
	</script>


<script>
	
	var pc_inputLeft = document.getElementById("pc_input-left");
	var pc_inputRight = document.getElementById("pc_input-right");

	var pc_thumbLeft = document.querySelector(".slider.pageCount > .thumb.left");
	var pc_thumbRight = document.querySelector(".slider.pageCount > .thumb.right");
	var pc_range = document.querySelector(".slider.pageCount > .range");

	var pc_minValueText = document.getElementById("pageCount-minValue");
	var pc_maxValueText = document.getElementById("pageCount-maxValue");


	var py_inputLeft = document.getElementById("py_input-left");
	var py_inputRight = document.getElementById("py_input-right");

	var py_thumbLeft = document.querySelector(".slider.publicYear > .thumb.left");
	var py_thumbRight = document.querySelector(".slider.publicYear > .thumb.right");
	var py_range = document.querySelector(".slider.publicYear > .range");

	var py_minValueText = document.getElementById("publicYear-minValue");
	var py_maxValueText = document.getElementById("publicYear-maxValue");



function setLeftValue(inpL, inpR, thL, rng, minText) {
	var _this = inpL,
		min = parseInt(_this.min),
		max = parseInt(_this.max);

	_this.value = Math.min(parseInt(_this.value), parseInt(inpR.value));

	var percent = ((_this.value - min) / (max - min)) * 100;

	thL.style.left = percent + "%";
	rng.style.left = percent + "%";

	minText.innerText = _this.value;
}

setLeftValue(pc_inputLeft,pc_inputRight,pc_thumbLeft,pc_range,pc_minValueText);
setLeftValue(py_inputLeft,py_inputRight,py_thumbLeft,py_range,py_minValueText);

function setRightValue(inpL, inpR, thR, rng, maxText) {
		var _this = inpR,
			min = parseInt(_this.min),
			max = parseInt(_this.max);

		_this.value = Math.max(parseInt(_this.value), parseInt(inpL.value));

		var percent = ((max - _this.value) / (max - min)) * 100;

		thR.style.right = percent + "%";
		rng.style.right = percent + "%";

		maxText.innerText = _this.value;
	}

setRightValue(pc_inputLeft,pc_inputRight,pc_thumbRight,pc_range,pc_maxValueText);
setRightValue(py_inputLeft,py_inputRight,py_thumbRight,py_range,py_maxValueText);

	function pageCount_setLeftValue() {
		setLeftValue(pc_inputLeft,pc_inputRight,pc_thumbLeft,pc_range,pc_minValueText);
	}
	function pageCount_setRightValue() {
		setRightValue(pc_inputLeft,pc_inputRight,pc_thumbRight,pc_range,pc_maxValueText);
	}
	function publicYear_setLeftValue() {
		setLeftValue(py_inputLeft,py_inputRight,py_thumbLeft,py_range,py_minValueText);
	}
	function publicYear_setRightValue() {
		setRightValue(py_inputLeft,py_inputRight,py_thumbRight,py_range,py_maxValueText);
	}

	pc_inputLeft.addEventListener("input", pageCount_setLeftValue);
	pc_inputRight.addEventListener("input", pageCount_setRightValue);
	py_inputLeft.addEventListener("input", publicYear_setLeftValue);
	py_inputRight.addEventListener("input", publicYear_setRightValue);





</script>