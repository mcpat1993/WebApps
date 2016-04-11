var mainInfo = {};
$(document).ready(function(){
	mainInfo = document.getElementById("mainInfo");
	populateCoursesDiv();
	//populateSelectedCourseDiv();
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
			$.each(data, function(slotname, slot){
				console.log(slot);
				if(slot !== null)
				{
					var listElement = document.createElement("li");
					listElement.id = slotname;
					listElement.innerHTML = slot;
					if(currentClassesStr.indexOf(slot) === -1)
					{
						currentClassesStr.push(slot);
					}
					listElement.onclick = function(){populateSelectedCourseDiv(slot);};
					listedCourses.appendChild(listElement);
				}
			});
			
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
			console.log(data);
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
			for(x=1;x<data.length;x++)
			{
				row = table.insertRow(x);
				row.id = "student"+x;
				firstName = row.insertCell(0);
				lastName = row.insertCell(1);
				firstName.innerHTML = data[x]["firstname"];
				lastName.innerHTML = data[x]["lastname"];
			}
			mainInfo.appendChild(table);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function showAddClassMenu()
{	
	mainInfo.innerHTML = "Please fill out the form to create a new class";
	//mainInfo.appendChild(instructions);
	var addForm = document.createElement("FORM");
	addForm.setAttribute('method',"post");
	addForm.setAttribute('action',"javascript:submitAddClass()");
	var classNameInput = document.createElement("INPUT");
	classNameInput.setAttribute('type', "text");
	classNameInput.setAttribute('type', "classname");
	classNameInput.setAttribute('id', "classname");
	
	var classSizeInput = document.createElement("INPUT");
	classSizeInput.setAttribute('type', "text");
	classSizeInput.setAttribute('type', "classsize");
	classSizeInput.setAttribute('id', "classsize");
	
	var classDescriptionInput = document.createElement("TEXTAREA");
	classDescriptionInput.setAttribute('cols', "50");
	classDescriptionInput.setAttribute('rows', "4");
	classDescriptionInput.setAttribute('class', "largeTextInput");
	classDescriptionInput.setAttribute('id', "classdescription");
	
	var classNameInputText = document.createElement("addClassPrompt1");
	classNameInputText.innerHTML = "Class Name: ";
	var classSizeInputText = document.createElement("addClassPrompt2");
	classSizeInputText.innerHTML = "Max Class Size: ";
	var classDescriptionInputText = document.createElement("addClassPrompt3");
	classDescriptionInputText.innerHTML = "Class Description: ";
	var addClassSubmit = document.createElement("INPUT");
	addClassSubmit.setAttribute('type', "submit");
	addClassSubmit.setAttribute('value', "Register Class");
	addClassSubmit.setAttribute('id', 'submitAddClass');
	addClassSubmit.click(function(e){
		e.preventDefault();
		console.log("foreal on click version of function");
	});
	
	addForm.appendChild(classNameInputText);
	addForm.appendChild(document.createElement("BR"));
	addForm.appendChild(classNameInput);
	addForm.appendChild(document.createElement("BR"));
	addForm.appendChild(classSizeInputText);
	addForm.appendChild(document.createElement("BR"));
	addForm.appendChild(classSizeInput);
	addForm.appendChild(document.createElement("BR"));
	addForm.appendChild(classDescriptionInputText);
	addForm.appendChild(document.createElement("BR"));
	addForm.appendChild(classDescriptionInput);
	addForm.appendChild(document.createElement("BR"));
	addForm.appendChild(addClassSubmit);
	
	mainInfo.appendChild(addForm);
}

function submitAddClass()
{
	console.log("submitAddClass reached!!!!!");
	var className = document.getElementById('classname').value;
	var classSize = document.getElementById('classsize').value;
	var classDescription = document.getElementById('classdescription').value;
	if(className.length == 0)
	{
		alert("You have to enter a class name!");
	}else
	{
		if(classSize.search(/^[0-9]*$/) === -1 || classSize.length >= 3)
		{
			alert("A class size has to be between 0 and 99!");
		}else
		{
			if(classDescription.length == 0)
			{
				alert("You have to enter a class description!");
			}else
			{
				if(currentClassesStr.indexOf(className) !== -1)
				{
					alert("Ummm Actually we only allow courses with unique names. That already exists as a course bruh!");
				}else
				{
					$.ajax({
					type: "POST",
					//dataType: "json",
					url: "processClass.php",
					data: {'classname':className, 'classsize':classSize, 'classdescription':classDescription},
					success: function(datas){
						console.log("SUCCESS SUBMITADDCLASS!");
						console.log(datas);
						console.log(datas["result"]);
						//alert(datas["result"]);
						//var resultMessage = document.createElement()
						populateCoursesDiv();
						var mainInfo = document.getElementById("mainInfo");
						mainInfo.innerHTML = "";
					},
					error: function(data){
						console.log("ERROR WAS: "+JSON.stringify(data, null, 4));
					}
					});
				}
			}
		}
	}
}

function showDropClassMenu()
{
	console.log("INSIDE SHOWDROPCLASSMENU");
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
			mainInfo.innerHTML = "";
			console.log("successfully deleted a class");
		}
		});
	}
}