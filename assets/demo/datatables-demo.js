// Initialize DataTables plugin with customization
$(document).ready(function() {
  $('#dataTable').DataTable({
    responsive: true,        
    paging: true,            
    pageLength: 10,           
    lengthMenu: [5, 10, 25, 50, 100], 
    ordering: true,          
    order: [[0, 'asc']],      
    searching: true,           
    columnDefs: [              
      { orderable: false, targets: [3, 4] } 
    ],
    language: {                
      search: "Filter Records:",
      lengthMenu: "Display _MENU_ records per page",
      zeroRecords: "No matching records found",
      info: "Showing _START_ to _END_ of _TOTAL_ records",
      infoEmpty: "No records available",
      infoFiltered: "(filtered from _MAX_ total records)"
    }
  });
});
