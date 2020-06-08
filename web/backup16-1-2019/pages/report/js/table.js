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
                            

                            if ( data == "wl" )
                            {
								var stnInfo = getObjects(STATION, 'id', v.id)[0];
                                if ( key == 0 )
                                {
                                    n = i + 1;
                                    n = (i + 1)*2;
									if (stnInfo.data.wl_down.enable)
									{
										thtr += '<th width="100" class="bd-left" title="'+stnInfo.name+'">'+stnInfo.code+' หน้า</th><th width="100">ท้าย</th>';
									}
                                    else
									{
										thtr += '<th width="100" colspan="2" class="bd-left" title="'+stnInfo.name+'">'+stnInfo.code+'</th>';
									}
                                }
								if (stnInfo.data.wl_down.enable)
								{
									tdtr += '<td class="bd-left">' + ((v.value1 == null) ? '' : v.value1) + ((v.dt1 == null) ? '' : '['+ v.dt1+']') +'</td>';
									tdtr += '<td>' + ((v.value2 == null) ? '' : v.value2) + ((v.dt2 == null) ? '' : '['+ v.dt2+']') + '</td>';
								}
								else
								{
									tdtr += '<td colspan="2" class="bd-left">' + ((v.value1 == null) ? '' : v.value1) + '</td>';
								}
                            }
                            else
                            {
								tdtr += '<td class="bd-left">' + ((v.value1 == null) ? '' : v.value1) + ((v.dt1 == null) ? '' : '['+ v.dt1+']') + '</td>';
                                if ( key == 0 )
                                {
									var stnInfo = getObjects(STATION, 'id', v.id)[0];
                                    n = i + 1;
                                    thtr += '<th width="100" class="bd-left" title="'+stnInfo.name+'">'+stnInfo.code+'</th>';
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