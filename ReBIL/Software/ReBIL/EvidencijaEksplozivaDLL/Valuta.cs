//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace EvidencijaEksplozivaDLL
{
    using System;
    using System.Collections.Generic;
    
    public partial class Valuta
    {
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2214:DoNotCallOverridableMethodsInConstructors")]
        public Valuta()
        {
            this.Smjestajs = new HashSet<Smjestaj>();
        }
    
        public string OznakaValute { get; set; }
        public string NazivValute { get; set; }
        public decimal Tecaj { get; set; }
    
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<Smjestaj> Smjestajs { get; set; }
    }
}
