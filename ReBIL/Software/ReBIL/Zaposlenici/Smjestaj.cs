//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace Zaposlenici
{
    using System;
    using System.Collections.Generic;
    
    public partial class Smjestaj
    {
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2214:DoNotCallOverridableMethodsInConstructors")]
        public Smjestaj()
        {
            this.Rezervacijas = new HashSet<Rezervacija>();
        }
    
        public int IDSmjestaj { get; set; }
        public string Naziv { get; set; }
        public string Lokacija { get; set; }
        public decimal CijenaPoOsobi { get; set; }
        public string OznakeValute { get; set; }
    
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<Rezervacija> Rezervacijas { get; set; }
        public virtual Valuta Valuta { get; set; }
    }
}
