<html>
    <head>
        <style>
            /*
Tables
---------------------------------------------------------------------------------------------------- */

            table {
                max-width: 100%;
            }

            th {
                text-align: left;
            }

            .table {
                width: 100%;
                margin-bottom: 20px;
            }

            .table > thead > tr > th,
            .table > tbody > tr > th,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > tbody > tr > td,
            .table > tfoot > tr > td {
                padding: 8px;
                line-height: 1.428571429;
                vertical-align: top;
                border-top: 1px solid #ddd;
            }

            .table > thead > tr > th {
                vertical-align: bottom;
                border-bottom: 2px solid #ddd;
            }

            .table > caption + thead > tr:first-child > th,
            .table > colgroup + thead > tr:first-child > th,
            .table > thead:first-child > tr:first-child > th,
            .table > caption + thead > tr:first-child > td,
            .table > colgroup + thead > tr:first-child > td,
            .table > thead:first-child > tr:first-child > td {
                border-top: 0;
            }

            .table > tbody + tbody {
                border-top: 2px solid #ddd;
            }

            .table .table {
                background-color: #fff;
            }

            .table-condensed > thead > tr > th,
            .table-condensed > tbody > tr > th,
            .table-condensed > tfoot > tr > th,
            .table-condensed > thead > tr > td,
            .table-condensed > tbody > tr > td,
            .table-condensed > tfoot > tr > td {
                padding: 5px;
            }

            .table-bordered {
                border: 1px solid #ddd;
            }

            .table-bordered > thead > tr > th,
            .table-bordered > tbody > tr > th,
            .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td,
            .table-bordered > tbody > tr > td,
            .table-bordered > tfoot > tr > td {
                border: 1px solid #ddd;
            }

            .table-bordered > thead > tr > th,
            .table-bordered > thead > tr > td {
                border-bottom-width: 2px;
            }

            .table-striped > tbody > tr:nth-child(odd) > td,
            .table-striped > tbody > tr:nth-child(odd) > th {
                background-color: #eaeaea;
            }

            .table-hover > tbody > tr:hover > td,
            .table-hover > tbody > tr:hover > th {
                background-color: #f5f5f5;
            }
        </style>
    </head>
    <body>
        <h1><?php echo $view_data['organization']['name']; ?></h1>
        <?php if ($view_data['action'] == 'list'): ?>
            <p><?php echo $view_data['title']; ?></p>
        <?php endif; ?>
        <?php echo $view_data['contentView']; ?>
        <p>Engineered by <?php echo \Config::get('product.name'); ?></p>
    </body>
</html>