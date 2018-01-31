jQuery(document).ready(function ($) {

  /**
   * Handle submit
   */
  function handleSubmit(form) {
    var ajaxSubmit = $('.fsk-info-content input[name="ajaxSubmit"]').val() && true || false;

    if (ajaxSubmit === true) {
      $.ajax(form.attr('action') + '&req=ajax')
        .done(function (obj) { }).fail(function (err) { });

      if ($('#fskPixelCrabLandingModal').length > 0) {
        $('#fskPixelCrabLandingModal').modal('hide');
        $('.modal-overlay').hide();
      }

      return;
    }

    form.submit();
    return;
  }

  /**
   * Handle click on submit button
   */
  function handleClick(form) {
    if (form.find('.birthdate-container').length > 0) {
      var uDate = new Date();
      var uDay = form.find('input[name="day"]').val() || uDate.getDate();
      var uMonth = (form.find('input[name="month"]').val() || uDate.getMonth() + 1) - 1;
      var uYear = form.find('input[name="year"]').val() || uDate.getFullYear();
      var minAge = form.find('input[name="minAge"]').val() || 0;

      if (uDay < 1 || uDay > 31) {
        uDay = uDate.getDate();
      }

      if (uMonth < 0 || uMonth > 11) {
        uMonth = uDate.getMonth();
      }

      if (uYear < 1900 || (uYear > uDate.getFullYear() + 120)) {
        uYear = uDate.getFullYear();
      }

      uDate.setDate(uDay);
      uDate.setMonth(uMonth);
      uDate.setYear(uYear);

      var ageDifMs = Date.now() - uDate.getTime();
      var ageDate = new Date(ageDifMs);
      var age = Math.abs(ageDate.getUTCFullYear() - 1970);

      if (age >= minAge) {
        form.find('input[type=number]').removeClass('error');
        handleSubmit(form);
      } else {
        form.find('input[type=number]').addClass('error');
        setTimeout(function () {
          form.find('input[type=number]').removeClass('error');
        }, 2000);
      }
    } else {
      handleSubmit(form);
    }
  }

  // If we have birthdate container we active maxlength plugin
  if ($('.birthdate-container input[type=number]').length > 0) {
    $('.birthdate-container input[type=number]').maxlength();
  }

  // Only show modal if it is neccessary
  if ($('#fskPixelCrabLandingModal').length > 0) {
    $('#fskPixelCrabLandingModal').modal({
      backdrop: 'static',
      keyboard: false
    }).on('hidden.bs.modal', function () {
      $(this).data('bs.modal', null);
    });

    $('.modal-overlay').show();

    $('#fskPixelCrabLandingModal').on('click', '.btn-success', function (e) {
      e.preventDefault();
      handleClick($('#fskPixelCrabLandingModal form'));
    });
  }

  // Only bind event on landing page if necessary
  if ($('#fskPixelCrabLandingPage').length > 0) {
    $('#fskPixelCrabLandingPage').on('click', '.btn-success', function (e) {
      e.preventDefault();
      handleClick($('#fskPixelCrabLandingPage form'));
    });
  }
});

