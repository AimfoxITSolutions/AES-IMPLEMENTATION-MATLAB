function [key9 new_state ] = Round19( state ,key ,s_box)
%UNTITLED4 Summary of this function goes here
%   Detailed explanation goes here

[ s_box,i_s_box ] = SBox();

    temp_state = state;

    for r_c = 1:9
        %step 1
        [ state1 ] = subsituteBytes( temp_state , s_box );
        %step 2
        [ state2 ] = shiftRows(state1);
        %step 3
        [ state3 ] = mixOfColumns(state2);
        %step 4
        %key
        key = keyExpansion( key, r_c );
        [ state4 ] = AddKey(key , state3 );
        temp_state = state4;

        %after loop
        new_state = state4;
    end
    key9 = key;
end

