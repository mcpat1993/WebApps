var mainInfo = undefined;
var allClasses = undefined;
$(document).ready(function(){
	mainInfo = document.getElementById("mainInfo");
	//console.log(mainInfo);
	populateCoursesDiv();
	//just testing the below
	
	
});

var currentClassesStr = [];


function populateCoursesDiv()
{
	console.log("Just some test output");
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "PHP/getClasses.php",
		data: {},
		success: function(data){
			console.log(data);
			var listedCourses = document.getElementById("classElements");
			listedCourses.innerHTML = "";
			var currClassNum = 1;
			$.each(data, function(slot){
				console.log(slot);
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
			
		},
		error: function(data){
			console.log(data);
		}
	});
}

function populateSelectedCourseDiv(selectedClass)
{
	console.log("Reached populateSelectedCourseDiv ->"+selectedClass+"<-");
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "getSelectedClass.php",
		data: {'selectedClass' : selectedClass},
		success: function(data){
			console.log("We got a success with data: ", data);
			console.log("------->"+data["numStudents"]);
			//var mainInfo = document.getElementById("mainInfo");
			mainInfo.innerHTML = "";
			var header = document.createElement("H1");
			header.innerHTML = selectedClass;
			mainInfo.appendChild(header);
			var description = document.createElement("desc");
			description.innerHTML = "Class Description: "+data["description"];
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
			console.log(table);
			for(x=0;x<data["numStudents"];x++)
			{
				row = table.insertRow(x+1);
				row.id = "student"+x;
				firstName = row.insertCell(0);
				lastName = row.insertCell(1);
				firstName.innerHTML = data[x+"f"];
				lastName.innerHTML = data[x+"l"];
				
				/*var listElement = document.createElement("li");
				listElement.id = "student"+x;
				console.log("-->"+data[x+"f"]);
				listElement.innerHTML = data[x+"f"] + " " + data[x+"l"];
				document.getElementById("classStudents").appendChild(listElement);*/
			}
			mainInfo.appendChild(table);
		}
	});
}

function showAddClassMenu()
{	
	console.log("Reached showAddClassMenu");
	mainInfo.innerHTML = "";
	mainInfo.innerHTML = "Please select a class that you'd like to sign up for:";
	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "PHP/getAllClasses.php",
		success: function(data){
			console.log(data);
			var form = document.createElement("FORM");
			form.setAttribute('action','javascript:submitAddClass()');
			form.setAttribute('method','post');
			var classesInputElements = [];
			for(x=0;x<data.length;x++)
			{
				allClasses = data;
				console.log("Are we iterating correctly? "+x);
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
	console.log("SubmitAddClass reached");
	
	/////////////
	var classes = document.getElementsByName("classes");
	var atLeastOne = -1;
	for(var q=0;q<classes.length;q++)
	{
		console.log("some ->"+classes[q]);
		if(classes[q].checked)
		{
			console.log("Definitely ONE checked");
			atLeastOne = q;
		}
	}
	console.log("adding "+classes[atLeastOne].name)
	if(atLeastOne === -1)
	{
		alert("Please select a damn course. Don't worry there is no god and you can't actually be damned :)");
	}else
	{
		console.log("This value is the arg passed to php file: "+classes[atLeastOne].value);
		$.ajax({
		type: "POST",
		url: "PHP/addClass.php",
		data: {'classtoadd':classes[atLeastOne].name},
		success: function(){
			console.log("successfully added a class");
			populateCoursesDiv();
		}
		});
	}
	//////////////////////
}

function showDropClassMenu()
{
	console.log("INSIDE SHOWDROPCLASSMENU");
	
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
		console.log("interation "+x+" for classes");
		//classes[x] = document.getElementById("class"+(x+1));
		//console.log(classes[x].innerHTML);
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
		//console.log("some ->"+classes[q]);
		if(classes[q].checked)
		{
			console.log("Definitely ONE checked");
			atLeastOne = q;
		}
		//alert('Please select a course to cancel.');
	}
	if(atLeastOne === -1)
	{
		alert("You need to actually select a class that you'd like to remove. I can't do all the work for you");
	}else
	{
		console.log("This value is the arg passed to php file: "+classes[atLeastOne].value);
		$.ajax({
		type: "POST",
		url: "PHP/removeClass.php",
		data: {'classtodelete':classes[atLeastOne].value},
		success: function(){
			var indexToDelete = currentClassesStr.indexOf(classes[atLeastOne].value);
			if (indexToDelete > -1) 
			{
				currentClassesStr.splice(indexToDelete, 1);
			}
			populateCoursesDiv();
			//var mainInfo = document.getElementById("mainInfo");
			mainInfo.innerHTML = "";
			console.log("successfully deleted a class");
		}
		});
	}
}