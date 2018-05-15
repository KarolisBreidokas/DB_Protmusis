$(window).ready(function() {

  $(".addChild").click(function() {
    // pagrindinis vaikinių įrašų konteineris
    childRowContainer = $(this).parent().prev(".childRowContainer");
    conid=childRowContainer[0].id;
    // pašaliname paslėptos eilutės požymius
    rowClone = $("#"+conid+".childform.hidden").clone(true, true);
    rowClone.removeClass("childform hidden");
    rowClone.addClass("childRow");
    rowClone.children().prop("disabled", false);
    rowClone.children(".cid").prop("disabled", true);
    childRowContainer.append(rowClone);
    clearDiv = $('<div />', {
      "class": 'float-clear'
    });
    childRowContainer.append(clearDiv);
    return false;
  })

  $(".removeChild").click(function() {
    // pagrindinis vaikinių įrašų konteineris
    childRowContainer = $(this).parent().parent(".childRowContainer");

    $(this).parent().next(".float-clear").remove();
    $(this).parent().remove();


    return false;
  })

  // Datos ir laiko įskiepių nustatymas
  $.datetimepicker.setLocale('lt');
  $('.datetime').datetimepicker({
    format: 'Y-m-d H:i',
    dayOfWeekStart: 1,
    startDate: '2016-01-01',
    defaultDate: '2016-01-01'
  });

  $('.date').datetimepicker({
    timepicker: false,
    format: 'Y-m-d',
    formatDate: 'Y-m-d',
    defaultDate: '2016-01-01'
  });


});

function showpicture(data) {
  var w = window.open("", "test", "toolbar=yes,top=500,left=500,width=400,height=400");
  var img = w.document.createElement("img");
  img.src = data;
  w.document.getElementsByTagName('body')[0].appendChild(img);
}


function showConfirmDialog(module, removeId) {
  var r = confirm("Ar tikrai norite pašalinti!");
  if (r === true) {
    window.location.replace("index.php?module=" + module + "&action=delete&id=" + removeId);
  }
}
