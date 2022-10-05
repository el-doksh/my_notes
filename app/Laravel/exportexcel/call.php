<?php

return Excel::download(new CustomersExport($request->all()), 'customers.xlsx');