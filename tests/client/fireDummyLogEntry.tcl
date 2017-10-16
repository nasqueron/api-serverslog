#!/usr/bin/env tclsh8.6

package require json::write
package require rest

proc dict2json {dictToEncode} {
    ::json::write object {*}[dict map {k v} $dictToEncode {
        set v [::json::write string $v]
    }]
}

proc get_source_script {} {
    file tail [info script]
}

rest::simple http://localhost:8000 {} {
    method PUT
    content-type application/json
    format json
} [dict2json "
    date [clock seconds]
    emitter Tests
    source [get_source_script]
    component Acme
    entry {Something happens.}
"]
