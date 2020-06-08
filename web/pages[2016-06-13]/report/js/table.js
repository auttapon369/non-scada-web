function runTable(json, data, caption)
{
    var thtr = null;
    var tdtr = null;
    var n = 0;

    $("#data").load
    (
        PATH_REPORT+"table.html",
        function() 
        {
            $.each
            (
                json,
                function(key, value)
                {
                    tdtr = '<td>'+value.date+'</td>';

                    $.each
                    (
                        value.stn,
                        function(i, v)
                        {
                            tdtr += '<td class="bd-left">'+v.value1+'</td>';

                            if ( data == "wl" )
                            {
                                if ( key == 0 )
                                {
                                    n = (i + 1)*2;
                                    thtr += '<th width="100" class="bd-left" title="'+v.name+'">'+v.code+'</th><th width="100">ท้าย</th>';
                                }

                                tdtr += '<td>'+v.value2+'</td>';
                            }
                            else
                            {
                                if ( key == 0 )
                                {
                                    n = i + 1;
                                    thtr += '<th width="100" class="bd-left" title="'+v.name+'">'+v.code+'</th>';
                                }
                            }
                        }                   
                    );
                    
                    $('#tbody').append('<tr>'+tdtr+'</tr>');
                }
            );

            $('.table caption').html(caption);
            $('.th-tr').append(thtr);
            $('.th-'+data).attr('colspan',n);
            $('.th-'+data).show();
            
            $('#data').append
            (
                '<div class="row">'+
                    '<div class="col-sm-4 col-sm-offset-4">'+
                        '<button type="button" onclick="javascript:print()" class="btn btn-block btn-lg btn-danger">'+
                            '<span class="glyphicon glyphicon-print"></span> '+
                            'พิมพ์รายงาน'+
                        '</button>'+
                    '</div>'+
                '</div>'
            );

            $(".loader").delay(2000).fadeOut();
        }
    );
}