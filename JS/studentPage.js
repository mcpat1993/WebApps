var mainInfo = undefined;
var allClasses = undefined;
$(document).ready(function(){
	mainInfo = document.getElementById("mainInfo");
	populateCoursesDiv();
});

var currentClassesStr = [];


function populateCoursesDiv()
{
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "PHP/getClasses.php",
		data: {},
		success: function(data){
			var listedCourses = document.getElementById("classElements");
			listedCourses.innerHTML = "";
			var currClassNum = 1;
			$.each(data, function(slot){
				if(data[slot] !== null)
				{
					var listElement = document.createElement("li");
					listElement.id = "class"+currClassNum;
					listElement.innerHTML = data[slot];
					if(currentClassesStr.indexOf(data[slot]) === -1)
					{
						currentClassesStr.push(data[slot]);
					}
					listElement.onclick = function(){populateSelectedCourseDiv(data[slot]);};
					listedCourses.appendChild(listElement);
				}
				currClassNum++;
			});
			
		}
	});
}

function populateSelectedCourseDiv(selectedClass)
{
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "getSelectedClass.php",
		data: {'selectedClass' : selectedClass},
		success: function(data){
			mainInfo.innerHTML = "";
			var header = document.createElement("H1");
			header.innerHTML = selectedClass;
			mainInfo.appendChild(header);
			var description = document.createElement("desc");
			description.innerHTML = "Class Description: "+data[0]["description"];
			mainInfo.appendChild(description);
			mainInfo.appendChild(document.createElement("BR"));
			mainInfo.appendChild(document.createElement("BR"));
			var table = document.createElement("TABLE");
			var tableHeader1 = document.createElement("TH");
			tableHeader1.innerHTML = "First Name";
			var tableHeader2 = document.createElement("TH");
			tableHeader2.innerHTML = "Last Name";
			var headerRow = table.insertRow(0);
			headerRow.appendChild(tableHeader1);
			headerRow.appendChild(tableHeader2);
			for(x=0;x<data["numStudents"];x++)
			{
				row = table.insertRow(x+1);
				row.id = "student"+x;
				firstName = row.insertCell(0);
				lastName = row.insertCell(1);
				firstName.innerHTML = data[x+"f"];
				lastName.innerHTML = data[x+"l"];
				
			}
			mainInfo.appendChild(table);
		}
	});
}

function showAddClassMenu()
{	
	mainInfo.innerHTML = "";
	mainInfo.innerHTML = "Please select a class that you'd like to sign up for:";
	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "PHP/getAllClasses.php",
		success: function(data){
			var form = document.createElement("FORM");
			form.setAttribute('action','javascript:submitAddClass()');
			form.setAttribute('method','post');
			var classesInputElements = [];
			for(x=0;x<data.length;x++)
			{
				//This check is just to make sure that the classes you are already signed up 
				//for don't show up as options of classes to sign up for
				if($("#class1").html() !== data[x].name && $("#class2").html() !== data[x].name && $("#class3").html() !== data[x].name)
				{
					allClasses = data;
					classesInputElements[x] = document.createElement("INPUT");
					classesInputElements[x].setAttribute('type', "radio");
					classesInputElements[x].setAttribute('name', "classes");
					classesInputElements[x].setAttribute('value', data[x].name);
					label = document.createElement(data[x].name+"label")
					label.innerHTML = data[x].name;
					form.appendChild(label);
					form.appendChild(classesInputElements[x]);
					form.appendChild(document.createElement("BR"));
				}
			}
			var submitButton = document.createElement("INPUT");
			submitButton.setAttribute('type', 'submit');
			submitButton.setAttribute('value', 'Add Course');
			form.appendChild(submitButton);
			mainInfo.appendChild(form);
		}
	});
}

function submitAddClass()
{
	
	var classes = document.getElementsByName("classes");
	var atLeastOne = -1;
	for(var q=0;q<classes.length;q++)
	{
		if(classes[q].checked)
		{
			atLeastOne = q;
		}
	}
	if(atLeastOne === -1)
	{
		alert("Please select a damn course. Don't worry there is no god and you can't actually be damned :)");
	}else
	{
		var classBeingAdded = classes[atLeastOne].value;
		$.ajax({
		type: "POST",
		dataType: "json",
		url: "PHP/addClass.php",
		data: {'classname':classBeingAdded},
		success: function(data){
			console.log(data);
			$("#notification").fadeIn("slow");
			$("#notification > #text").html(data["result"]);
			$(".dismiss").click(function(){
				   $("#notification").fadeOut("slow");
			});
			populateCoursesDiv();
			mainInfo.innerHTML = "";
		},
		error: function(data){
			console.log(data);
		}
		});
	}
}

function showDropClassMenu()
{
	
	mainInfo.innerHTML = "";
	mainInfo.innerHTML = "Please select the class you would like to cancel:";
	
	var classesNow = document.getElementsByName("classes");
	var form = document.createElement("FORM");
	form.setAttribute('action','javascript:removeClass()');
	form.setAttribute('method','post');
	var classes = [];
	var classesInputElements = [];
	for(x=0;x<currentClassesStr.length;x++)
	{
		classesInputElements[x] = document.createElement("INPUT");
		classesInputElements[x].setAttribute('type', "radio");
		classesInputElements[x].setAttribute('name', "classes");
		classesInputElements[x].setAttribute('value', currentClassesStr[x]);
		label = document.createElement(currentClassesStr[x]+"label")
		label.innerHTML = currentClassesStr[x];
		form.appendChild(label);
		form.appendChild(classesInputElements[x]);
		form.appendChild(document.createElement("BR"));
	}
	var submitButton = document.createElement("INPUT");
	submitButton.setAttribute('type', 'submit');
	submitButton.setAttribute('value', 'Cancel Course ');
	form.appendChild(submitButton);
	mainInfo.appendChild(form);
}

function removeClass()
{
	var classes = document.getElementsByName("classes");
	var atLeastOne = -1;
	for(var q=0;q<classes.length;q++)
	{
		if(classes[q].checked)
		{
			atLeastOne = q;
		}
	}
	
	$.ajax({
	type: "POST",
	url: "PHP/removeFromClass.php",
	data: {'classname':classes[atLeastOne].value},
	success: function(){
		var indexToDelete = currentClassesStr.indexOf(classes[atLeastOne].value);
		$("#notification").fadeIn("slow");
		$("#notification > #text").html(classes[atLeastOne].value+" removed!");
		$(".dismiss").click(function(){
			   $("#notification").fadeOut("slow");
		});
		if (indexToDelete > -1) 
		{
			currentClassesStr.splice(indexToDelete, 1);
		}
		populateCoursesDiv();
		mainInfo.innerHTML = "";
	}
	});
}