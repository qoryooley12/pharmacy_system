$(document).ready(function() {
  $("#userSelect").change(function() {
    let userId = $(this).val();
    if (userId) {
      $("#permissionsSection").removeClass("d-none");

      // AJAX call to fetch user permissions
     $.ajax({
  url: "../api/user-permission.php",
  method: "POST",
  data: {
    action: "fetch_permissions",
    user_id: userId
  },
  dataType: "json",
  success: function(response) {
    $("input[name='permissions[]']").prop("checked", false);
    if (response.permissions) {
      response.permissions.forEach(function(p) {
        $("input[value='" + p + "']").prop("checked", true);
      });
    }
  }
});


    } else {
      $("#permissionsSection").addClass("d-none");
    }
  });

  $("#savePermissions").click(function() {
    let userId = $("#userSelect").val();
    let perms = [];
    $("input[name='permissions[]']:checked").each(function() {
      perms.push($(this).val());
    });

    // Save
   $.ajax({
  url: "../api/user-permission.php",
  method: "POST",
  data: {
    action: "save_permissions",
    user_id: userId,
    permissions: perms
  },
  success: function(response) {
    alert("Permissions saved successfully!");
  }
});

  });
});