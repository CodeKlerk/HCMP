Imports InfoSoftGlobal

Partial Class SimpleChart
    Inherits System.Web.UI.Page



    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load

        'This page demonstrates the ease of generating charts using FusionCharts.
        'For this chart, we've used a pre-defined Data.xml (contained in /Data/ folder)
        'Ideally, you would NOT use a physical data file. Instead you'll have 
        'your own ASP.NET scripts virtually relay the XML data document. Such examples are also present.
        'For a head-start, we've kept this example very simple.
        'Create the chart - Column 3D Chart with data from Data/Data.xml

        Literal1.Text = FusionCharts.RenderChart("../FusionCharts/Column3D.swf", "Data/Data.xml", "", "myFirst", "600", "300", False, True)


    End Sub
End Class
