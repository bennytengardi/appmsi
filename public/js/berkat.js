$(function () {
  $("#example0").DataTable();

  $("#example2").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: true,
    responsive: true,
  });

  $("#example3").DataTable({
    paging: true,
    searching: true,
    info: true,
  });
});

$(".custom-file-input").on("change", function () {
  let fileName = $(this).val().split("\\").pop();
  $(this).next(".custom-file-label").addClass("selected").html(fileName);
});

var flash = $("#flash").data("flash");
if (flash) {
  Swal.fire({
    icon: "success",
    title: "sukses",
    text: flash,
    showClass: {
      popup: "animate__animated animate__fadeInDown",
    },
    hideClass: {
      popup: "animate__animated animate__fadeOutUp",
    },
  });
}

$(document).on("click", "#btn-hapus", function (e) {
  e.preventDefault();
  var link = $(this).attr("href");
  Swal.fire({
    title: "Apakah anda yakin?",
    text: "Data ini mau dihapus!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya, Hapus!",
    cancelButtonText: "Batal!",
    showClass: {
      popup: "animate__animated animate__fadeInDown",
    },
    hideClass: {
      popup: "animate__animated animate__fadeOutUp",
    },
  }).then((result) => {
    if (result.value) {
      window.location = link;
    }
  });
});

// No urut Kode Barang
$("#id_group").on("change", function () {
  var id_group = $(this).val();
  $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "<?= base_url('group/get_data_group') ?>",
    data: {
      id_group: id_group,
    },
    success: function (data) {
      $.each(data, function (kode_group, no_urut) {
        const urut = parseInt(data.no_urut) + 1;
        const urutstr = urut.toString();
        const urutnum = urutstr.padStart(5, "0");
        var kode = data.kode_group + "-" + urutnum;
        $("#kode_barang").val(kode);
        $("#nama_barang").focus();
      });
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    },
  });
  return false;
});

function bacaGambar(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#gambar_load").attr("src", e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

$("#preview_gambar").change(function () {
  bacaGambar(this);
});

// Number Only
$(".number_only").keypress(function (e) {
  return isNumbers(e, this);
});

function isNumbers(evt, element) {
  var charCode = evt.which ? evt.which : event.keyCode;
  if (
    (charCode != 46 || $(element).val().indexOf(".") != -1) && // “.” CHECK DOT, AND ONLY ONE.
    (charCode < 48 || charCode > 57)
  )
    return false;
  return true;
}

$(document).on("click", ".tombol-barang", function () {
  brs = $(this).attr("data-srno");
  $("#modal-barang").modal("show");
});

$(document).on("click", "#selectplist", function (e) {
  e.preventDefault();
  var id_barang = $(this).data("id_barang");
  var kode_barang = $(this).data("kode_barang");
  var nama_barang = $(this).data("nama_barang");
  var satuan = $(this).data("satuan");
  var id_satuan = $(this).data("id_satuan");

  $("#kode_barang").val(kode_barang);
  $("#id_barang").val(id_barang);
  $("#nama_barang").val(nama_barang);
  $("#satuan").val(satuan);
  $("#id_satuan").val(id_satuan);
  $("#modal-barang").modal("hide");
});

$(document).on("click", "#selectplist3", function (e) {
  e.preventDefault();
  var id_barang = $(this).data("id_barang");
  var kode_barang = $(this).data("kode_barang");
  var nama_barang = $(this).data("nama_barang");
  var satuan = $(this).data("satuan");
  var id_satuan = $(this).data("id_satuan");

  $("#kode_barang3").val(kode_barang);
  $("#id_barang3").val(id_barang);
  $("#nama_barang3").val(nama_barang);
  $("#satuan3").val(satuan);
  $("#id_satuan3").val(id_satuan);
  $("#modal-barang3").modal("hide");
});

$(document).on("blur", ".kode_barang3", function () {
  var kode_barang = $(this).val();
  $.ajax({
    type: "POST",
    url: "<?php echo base_url('barang/cari_kodebarang') ?>",
    dataType: "JSON",
    data: {
      kode_barang: kode_barang,
    },
    cache: false,
    success: function (data) {
      $.each(
        data,
        function (id_barang, kode_barang, id_satuan, satuan, nama_barang) {
          $("#id_barang").val(data.id_barang);
          $("#nama_barang").val(data.nama_barang);
          $("#id_satuan").val(data.id_satuan);
          $("#satuan").val(data.satuan);
          $("#harga").focus();
        }
      );
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    },
  });
  return false;
});

$(document).ready(function () {
  function autonum() {
    $(".autonum").autoNumeric("init", {
      aSep: ",",
      aDec: ".",
      mDec: "0",
    });
    $(".autonum2").autoNumeric("init", {
      aSep: ",",
      aDec: ".",
      mDec: "2",
    });
  }
  autonum();
});

window.setTimeout(function () {
  $(".alert")
    .fadeTo(500, 0)
    .slideUp(500, function () {
      $(this).remove();
    });
}, 1500);

// PRICE LIST CUSTOMER

$("#id_typeprice").on("change", function (e) {
  e.preventDefault();
  var id_typeprice = $(this).val();
  showitem(id_typeprice);
});

function showitem(id_type) {
  $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "<?= base_url('pricelist/get_data') ?>",
    data: {
      id_typeprice: id_type,
    },

    success: function (data) {
      var html = "";
      var i = 0;
      var no = 1;
      for (i = 0; i < data.length; i++) {
        var id_typeprice = data[i].id_typeprice;
        var idprice = data[i].id_price;
        var namabarang = data[i].nama_barang;
        var kodebarang = data[i].kode_barang;
        var satuan = data[i].satuan;
        var harga = data[i].harga;

        html +=
          "<tr>" +
          '<td align="center">' +
          no++ +
          "</td>" +
          "<td>" +
          kodebarang +
          "</td>" +
          "<td>" +
          namabarang +
          "</td>" +
          '<td class="text-center">' +
          satuan +
          "</td>" +
          '<td class="text-right">' +
          harga +
          "</td>" +
          '<td class="text-center">' +
          '<button class="btn btn-info btn-xs text-sm mr-2 tomboledit" data-toggle="modal" data-target="#modal-edit" data-id_price="' +
          idprice +
          '" data-nama_barang = "' +
          namabarang +
          '" data-kode_barang = "' +
          kodebarang +
          '" data-satuan="' +
          satuan +
          '" data-harga="' +
          harga +
          '" data-id_typeprice="' +
          id_typeprice +
          '"><i class="fa fa-pencil-alt"></i></button>' +
          '<button type="button" class="btn btn-danger btn-xs text-sm mr-2" onclick="hapusprice(' +
          idprice +
          ",'" +
          namabarang +
          "','" +
          id_type +
          '\')"><i class="fa fa-trash"></i></button>' +
          "</td>" +
          "</tr>";
      }

      html +=
        "<tr>" +
        '<td class="text-center"><button class="btn btn-success btn-xs tomboladd" data-toggle="modal" data-target="#modal-add" data-id_typeprice = "' +
        id_type +
        '" ><i class="fa fa-plus"></i></button></td>' +
        '<td colspan="5"></td>' +
        "</tr>";
      $("#totalitem").val(i);
      $("#show_item").html(html);
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    },
  });
  return false;
}

$(document).on("click", ".tomboledit", function (e) {
  e.preventDefault();
  var id_typeprice = $(this).data("id_typeprice");
  var id_price = $(this).data("id_price");
  var kode_barang = $(this).data("kode_barang");
  var nama_barang = $(this).data("nama_barang");
  var satuan = $(this).data("satuan");
  var harga = $(this).data("harga");

  $("#id_typepricey").val(id_typeprice);
  $("#id_price").val(id_price);
  $("#kode_barang1").val(kode_barang);
  $("#nama_barang1").val(nama_barang);
  $("#satuan1").val(satuan);
  $("#harga1").val(harga);
  $("#modal-edit").modal("show");
});

$(document).on("click", ".tomboladd", function (e) {
  e.preventDefault();
  var id_typeprice = $(this).data("id_typeprice");
  $("#form-add-price")[0].reset();
  $("#modal-add").modal("show");
  $("#id_typepricex").val(id_typeprice);
});

$(".tombolSimpanPrice").click(function (e) {
  e.preventDefault();
  let form = $("#form-add-price")[0];
  let data = new FormData(form);
  var id_typeprice = $("#id_typepricex").val();

  $.ajax({
    type: "post",
    url: "<?= base_url('pricelist/insert') ?>",
    data: data,
    dataType: "json",
    processData: false,
    contentType: false,
    cache: false,
    beforeSend: function () {
      $(".tombolSimpanPrice").html('<i class="fa fa-spin fa-spinner"></i>');
      $(".tombolSimpanPrice").prop("disabled", true);
    },
    complete: function () {
      $(".tombolSimpanPrice").html("Save");
      $(".tombolSimpanPrice").prop("disabled", false);
    },
    success: function (response) {
      Swal.fire({
        icon: "success",
        title: "Berhasil",
        html: response.sukses,
      }).then((result) => {
        if (result.value) {
          $("#modal-add").modal("hide");
          showitem(id_typeprice);
          // window.location = '<?= base_url('pricelist') ?>';
        }
      });
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    },
  });
});

$(".tombolEditPrice").click(function (e) {
  e.preventDefault();
  let form = $("#form-edit-price")[0];
  let data = new FormData(form);
  var id_typeprice = $("#id_typepricey").val();

  $.ajax({
    type: "post",
    url: "<?= base_url('pricelist/update') ?>",
    data: data,
    dataType: "json",
    processData: false,
    contentType: false,
    cache: false,
    beforeSend: function () {
      $(".tombolEditPrice").html('<i class="fa fa-spin fa-spinner"></i>');
      $(".tombolEditPrice").prop("disabled", true);
    },
    complete: function () {
      $(".tombolEditPrice").html("Update");
      $(".tombolEditPrice").prop("disabled", false);
    },
    success: function (response) {
      Swal.fire({
        icon: "success",
        title: "Berhasil",
        html: response.sukses,
      }).then((result) => {
        if (result.value) {
          $("#modal-edit").modal("hide");
          showitem(id_typeprice);
        }
      });
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    },
  });
});

function hapusprice(idprice, namabarang, id_type) {
  Swal.fire({
    html: `Yakin mau menghapus <strong>${namabarang}</strong> `,
    text: "Data ini mau dihapus!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya, Hapus!",
    cancelButtonText: "Batal!",
    showClass: {
      popup: "animate__animated animate__fadeIn",
    },
    hideClass: {
      popup: "animate__animated animate__fadeOutUp",
    },
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: "post",
        url: "<?= base_url('pricelist/delete') ?>",
        data: {
          id_price: idprice,
        },
        dataType: "json",
        success: function (response) {
          if (response.sukses) {
            Swal.fire({
              icon: "success",
              title: "Berhasil",
              text: response.sukses,
              confirmButtonColor: "#00a65a",
              showClass: {
                popup: "animate__animated animate__fadeIn",
              },
              hideClass: {
                popup: "animate__animated animate__fadeOutUp",
              },
            }).then((result) => {
              if (result.value) {
                showitem(id_type);
              }
            });
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
      });
    }
  });
}

// PRICE LIST SUPPLIER

$("#id_supplier2").on("change", function (e) {
  e.preventDefault();
  var id_supplier = $(this).val();
  showitem3(id_supplier);
});

function showitem3(id_supp) {
  $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "<?= base_url('pricesupp/get_data') ?>",
    data: {
      id_supplier: id_supp,
    },
    success: function (data) {
      var html = "";
      var i = 0;
      var no = 1;
      for (i = 0; i < data.length; i++) {
        var id_supplier = data[i].id_supplier;
        var idprice = data[i].id_price;
        var namabarang = data[i].nama_barang;
        var kodebarang = data[i].kode_barang;
        var satuan = data[i].satuan;
        var harga = data[i].harga;
        var disc1 = data[i].disc1;
        var disc2 = data[i].disc2;

        html +=
          "<tr>" +
          '<td align="center">' +
          no++ +
          "</td>" +
          "<td>" +
          kodebarang +
          "</td>" +
          "<td>" +
          namabarang +
          "</td>" +
          '<td class="">' +
          satuan +
          "</td>" +
          '<td class="text-right">' +
          harga +
          "</td>" +
          '<td class="text-right">' +
          disc1 +
          "</td>" +
          '<td class="text-right">' +
          disc2 +
          "</td>" +
          '<td class="text-center">' +
          '<button class="btn btn-info btn-xs text-sm mr-2 tomboleditbeli" data-toggle="modal" data-target="#modal-edit" data-id_price="' +
          idprice +
          '" data-nama_barang = "' +
          namabarang +
          '" data-kode_barang = "' +
          kodebarang +
          '" data-satuan="' +
          satuan +
          '" data-harga="' +
          harga +
          '" data-disc1="' +
          disc1 +
          '" data-disc2="' +
          disc2 +
          '" data-id_supplier="' +
          id_supplier +
          '"><i class="fa fa-pencil-alt"></i></button>' +
          '<button type="button" class="btn btn-danger btn-xs text-sm mr-2" onclick="hapuspricebeli(' +
          idprice +
          ",'" +
          namabarang +
          "','" +
          id_supplier +
          '\')"><i class="fa fa-trash"></i></button>' +
          "</td>" +
          "</tr>";
      }
      html +=
        "<tr>" +
        '<td class="text-center"><button class="btn btn-success btn-xs tomboladdbeli" data-toggle="modal" data-target="#modaladd3" data-id_supplier= "' +
        id_supplier +
        '" ><i class="fa fa-plus"></i></button></td>' +
        '<td colspan="7"></td>' +
        "</tr>";
      $("#totalitem").val(i);
      $("#showitem3").html(html);
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    },
  });
  return false;
}

$(document).on("click", ".tomboledit", function (e) {
  e.preventDefault();
  var id_typeprice = $(this).data("id_typeprice");
  var id_price = $(this).data("id_price");
  var kode_barang = $(this).data("kode_barang");
  var nama_barang = $(this).data("nama_barang");
  var satuan = $(this).data("satuan");
  var harga = $(this).data("harga");

  $("#id_typepricey").val(id_typeprice);
  $("#id_price").val(id_price);
  $("#kode_barang1").val(kode_barang);
  $("#nama_barang1").val(nama_barang);
  $("#satuan1").val(satuan);
  $("#harga1").val(harga);
  $("#modal-edit").modal("show");
});

$(document).on("click", ".tomboladdbeli", function (e) {
  e.preventDefault();
  var id_supplier = $(this).data("id_supplier");
  console.log(id_supplier);
  $("#form-add-price3")[0].reset();
  $("#modaladd").modal("show");
  $("#id_supplierx").val(id_supplier);
});

$(".tombolSimpanPrice3").click(function (e) {
  e.preventDefault();
  let form = $("#form-add-price3")[0];
  let data = new FormData(form);
  var id_supplier = $("#id_supplierx").val();

  $.ajax({
    type: "post",
    url: "<?= base_url('pricesupp/insert') ?>",
    data: data,
    dataType: "json",
    processData: false,
    contentType: false,
    cache: false,
    beforeSend: function () {
      $(".tombolSimpanPrice3").html('<i class="fa fa-spin fa-spinner"></i>');
      $(".tombolSimpanPrice3").prop("disabled", true);
    },
    complete: function () {
      $(".tombolSimpanPrice3").html("Save");
      $(".tombolSimpanPrice3").prop("disabled", false);
    },
    success: function (response) {
      Swal.fire({
        icon: "success",
        title: "Berhasil",
        html: response.sukses,
      }).then((result) => {
        if (result.value) {
          $("#modaladd").modal("hide");
          showitem3(id_supplier);
        }
      });
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    },
  });
});

$(".tombolEditPrice").click(function (e) {
  e.preventDefault();
  let form = $("#form-edit-price")[0];
  let data = new FormData(form);
  var id_typeprice = $("#id_typepricey").val();

  $.ajax({
    type: "post",
    url: "<?= base_url('pricelist/update') ?>",
    data: data,
    dataType: "json",
    processData: false,
    contentType: false,
    cache: false,
    beforeSend: function () {
      $(".tombolEditPrice").html('<i class="fa fa-spin fa-spinner"></i>');
      $(".tombolEditPrice").prop("disabled", true);
    },
    complete: function () {
      $(".tombolEditPrice").html("Update");
      $(".tombolEditPrice").prop("disabled", false);
    },
    success: function (response) {
      Swal.fire({
        icon: "success",
        title: "Berhasil",
        html: response.sukses,
      }).then((result) => {
        if (result.value) {
          $("#modal-edit").modal("hide");
          showitembeli(id_typeprice);
        }
      });
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    },
  });
});

function hapusprice(idprice, namabarang, id_type) {
  Swal.fire({
    html: `Yakin mau menghapus <strong>${namabarang}</strong> `,
    text: "Data ini mau dihapus!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#00a65a",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya, Hapus!",
    cancelButtonText: "Batal!",
    showClass: {
      popup: "animate__animated animate__fadeIn",
    },
    hideClass: {
      popup: "animate__animated animate__fadeOutUp",
    },
  }).then((result) => {
    if (result.value) {
      $.ajax({
        type: "post",
        url: "<?= base_url('pricelist/delete') ?>",
        data: {
          id_price: idprice,
        },
        dataType: "json",
        success: function (response) {
          if (response.sukses) {
            Swal.fire({
              icon: "success",
              title: "Berhasil",
              text: response.sukses,
              confirmButtonColor: "#00a65a",
              showClass: {
                popup: "animate__animated animate__fadeIn",
              },
              hideClass: {
                popup: "animate__animated animate__fadeOutUp",
              },
            }).then((result) => {
              if (result.value) {
                showitembeli(id_type);
                // window.location = '<?= base_url('pricelist') ?>';
              }
            });
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
      });
    }
  });
}
